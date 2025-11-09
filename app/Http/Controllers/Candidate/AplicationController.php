<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\MatchScore;
use App\Services\CvTextExtractor;
use App\Services\MatchScoringService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AplicationController extends Controller
{
    /**
     * POST /candidato/aplicar/{job}
     * Requiere: auth + role Candidato (middleware)
     */
    public function store(Job $job, CvTextExtractor $cvx, MatchScoringService $gemini)
    {
        // 1) Solo permitir si la vacante está abierta
        abort_unless(($job->status ?? 'open') === 'open', 404);

        // 2) Conseguir (o crear) el Candidate del usuario autenticado
        $candidate = Candidate::firstOrCreate(['user_id' => Auth::id()]);

        // 3) Evitar postulación duplicada
        $exists = Application::where('candidate_id', $candidate->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya te postulaste a esta vacante.');
        }

        return DB::transaction(function () use ($job, $candidate, $cvx, $gemini) {

            // 4) Crear la postulación inicial (sin score aún)
            $app = Application::create([
                'candidate_id' => $candidate->id,
                'job_id'       => $job->id,
                'status'       => 'applied',
                'score'        => null,
            ]);

            // 5) Preparar payloads para el servicio de match 
            // Lee y limita texto del CV si existe (el CvTextExtractor debe tolerar null/archivo no soportado)
            $cvText = $cvx->fromPublicPath($candidate->cv_file);

            $candPayload = [
                'name'             => optional($candidate->user)->name,
                'summary'          => $candidate->summary,
                'experience_years' => (int) $candidate->experience_years,
                'education'        => $candidate->education,
                'cv_text'          => $cvText,
            ];

            $jobPayload = [
                'title'        => $job->title,
                'company'      => optional($job->company)->name,
                'location'     => $job->location,
                'description'  => $job->description,
                'requirements' => $job->requirements,
            ];

            // 6) Llamar a Gemini (con fallback interno si falla)
            // El servicio devuelve: ['score'=>int, 'comment'=>string, 'red_flags'=>[], 'raw'=>string]
            $result   = $gemini->score($candPayload, $jobPayload);
            $score    = (int) ($result['score'] ?? 0);
            $comment  = (string) ($result['comment'] ?? '');

            // 7) Persistir score en la postulación
            $app->update(['score' => $score]);

            // 8) Guardar historial en match_scores
            MatchScore::create([
                'job_id'              => $job->id,
                'candidate_id'        => $candidate->id,
                'compatibility_score' => $score,
                'comment'             => Str::limit($comment, 500, '…'),
                'analyzed_at'         => now(),
            ]);

            // 9) Listo
            return back()->with('status', 'Postulación enviada y analizada (IA). Compatibilidad: ' . $score . '%.');
        });
    }
}
