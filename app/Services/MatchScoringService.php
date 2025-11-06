<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MatchScoringService
{
    /**
     * Calcula score + comentario usando Gemini (con fallback local).
     *
     * Devuelve:
     * [
     *   'score'     => int 0..100,
     *   'comment'   => string (explicación del score),
     *   'red_flags' => array<string>,
     *   'raw'       => string (respuesta cruda del modelo)
     * ]
     */
    public function score(array $candidate, array $job): array
    {
        // Pedimos específicamente "comment" en el JSON:
        $system = <<<SYS
Eres un evaluador técnico de RRHH. Compara el perfil y CV del candidato con la vacante.
Responde ESTRICTAMENTE en JSON (sin texto adicional) con este esquema:

{
  "score_0_100": number,   // entero 0..100
  "comment": string,       // explica brevemente por qué diste ese score (máx ~3 líneas)
  "red_flags": string[]    // lista corta de riesgos detectados (puede estar vacía)
}

No agregues backticks ni texto fuera del JSON.
SYS;

        // Contenido a evaluar (incluye descripción y requisitos del job)
        $user = "[Vacante]\n".$this->jobBlock($job)."\n\n[Candidato]\n".$this->candidateBlock($candidate);

        $model    = config('services.gemini.model');
        $endpoint = rtrim(config('services.gemini.endpoint'), '/')."/{$model}:generateContent";
        $apiKey   = config('services.gemini.api_key');

        $payload = [
            'contents' => [
                'parts' => [
                    ['text' => $system],
                    ['text' => $user],
                ],
            ],
            'generationConfig' => [
                'temperature'      => 0.2,
                'maxOutputTokens'  => 512,
                'topP'             => 0.9,
            ],
        ];

        try {
            $res = Http::timeout(20)
                ->acceptJson()
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post($endpoint, $payload)
                ->json();

            $raw  = $res['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $json = $this->safeJson($raw);

            if (!$json || !isset($json['score_0_100'])) {
                return $this->fallbackScore($candidate, $job, $raw);
            }

            // Mapeo: usamos "comment" como explicación del score (y limitamos un poco su longitud)
            $comment = (string) ($json['comment'] ?? ($json['summary'] ?? ''));
            $comment = Str::limit($comment, 500, '…');

            return [
                'score'     => max(0, min(100, (int) $json['score_0_100'])),
                'comment'   => $comment,
                'red_flags' => $json['red_flags'] ?? [],
                'raw'       => $raw,
            ];

        } catch (\Throwable $e) {
            return $this->fallbackScore($candidate, $job, 'error: '.$e->getMessage());
        }
    }

    // ---------- helpers ----------

    protected function candidateBlock(array $c): string
    {
        $lines = [];
        $lines[] = 'Nombre: '.($c['name'] ?? 'N/D');
        $lines[] = 'Resumen: '.($c['summary'] ?? '');
        $lines[] = 'Años experiencia: '.($c['experience_years'] ?? '0');
        $lines[] = 'Educación: '.($c['education'] ?? '');
        if (!empty($c['cv_text'])) {
            $lines[] = "CV (texto):\n".$c['cv_text'];
        }
        return implode("\n", $lines);
    }

    protected function jobBlock(array $j): string
    {
        $lines = [];
        $lines[] = 'Título: '.($j['title'] ?? '');
        $lines[] = 'Empresa: '.($j['company'] ?? '');
        $lines[] = 'Ubicación: '.($j['location'] ?? '');
        if (!empty($j['description'])) {
            $lines[] = "Descripción:\n".$j['description'];
        }
        if (!empty($j['requirements'])) {
            $lines[] = "Requisitos:\n".$j['requirements'];
        }
        return implode("\n", $lines);
    }

    /**
     * Intenta decodificar JSON, removiendo fences ```json ... ```
     */
    protected function safeJson(string $text): ?array
    {
        $text = trim($text);
        $text = preg_replace('/^```json/i', '', $text);
        $text = preg_replace('/```$/', '', $text);
        $text = trim($text);
        $decoded = json_decode($text, true);
        return is_array($decoded) ? $decoded : null;
    }

    /**
     * Fallback local si Gemini falla o devuelve algo no parseable.
     * Genera un score básico por intersección de tokens y un comentario breve.
     */
    protected function fallbackScore(array $c, array $j, string $raw): array
    {
        $candBlob = Str::lower(
            ($c['summary'] ?? '').' '.
            ($c['education'] ?? '').' '.
            ($c['cv_text'] ?? '')
        );

        $jobBlob  = Str::lower(
            ($j['description'] ?? '').' '.
            ($j['requirements'] ?? '')
        );

        $candTokens = collect(preg_split('/\W+/u', $candBlob, -1, PREG_SPLIT_NO_EMPTY))->unique();
        $jobTokens  = collect(preg_split('/\W+/u', $jobBlob, -1, PREG_SPLIT_NO_EMPTY))->unique();

        $inter = $jobTokens->intersect($candTokens)->count();
        $score = $jobTokens->count() ? (int) round(($inter / max(1, $jobTokens->count())) * 100) : 0;

        $comment = $score >= 60
            ? 'Alta coincidencia textual entre perfil/CV y la descripción/requisitos.'
            : ($score >= 30
                ? 'Coincidencia parcial; hay términos relevantes pero faltan varios requisitos.'
                : 'Baja coincidencia textual; el perfil no refleja los requisitos principales.');

        return [
            'score'     => $score,
            'comment'   => $comment,
            'red_flags' => [],
            'raw'       => $raw,
        ];
    }
}
