<?php

namespace App\Services;

use Illuminate\Support\Str;

class CvTextExtractor
{
    /**
     * Recibe una ruta relativa al disco "public" (por ejemplo "cv/xyz.pdf")
     * Devuelve texto (máx ~8k chars) o null si no se puede extraer.
     */
    public function fromPublicPath(?string $relativePath): ?string
    {
        if (!$relativePath) return null;

        $full = storage_path('app/public/'.$relativePath);
        if (!is_file($full)) return null;

        $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));

        if ($ext === 'pdf') {
            return $this->fromPdf($full);
        }

        // TODO: agregar .docx si lo necesitas
        return null;
    }

    protected function fromPdf(string $fullpath): ?string
    {
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseFile($fullpath);
            $text   = trim($pdf->getText() ?? '');
            if ($text === '') return null;
            // limitar tamaño para no exceder tokens
            return Str::limit($text, 8000, '…');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
