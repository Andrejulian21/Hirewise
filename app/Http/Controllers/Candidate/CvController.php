<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    // Helper: comprueba rol sin depender de hasRole()
    protected function userHasRole($user, string $roleName): bool
    {
        if (!$user) return false;

        // Si existe hasRole (Spatie), úsalo
        if (method_exists($user, 'hasRole')) {
            return $user->hasRole($roleName);
        }

        // Fallback: relación roles() (Spatie) o tu relación equivalente
        return method_exists($user, 'roles')
            ? $user->roles()->where('name', $roleName)->exists()
            : false;
    }

    public function ver(int $candidateId)
    {
        $candidate = Candidate::findOrFail($candidateId);

        // Ruta relativa guardada (p.ej. "cv/archivo.pdf")
        $relative = ltrim((string) $candidate->cv_file, '/');
        if ($relative === '') {
            abort(404, 'Este candidato no tiene CV.');
        }

        $user = Auth::user();

        $isAdmin   = $this->userHasRole($user, 'Admin');
        $isEmpresa = $this->userHasRole($user, 'Empresa');
        $isCandOwn = $this->userHasRole($user, 'Candidato') && $candidate->user_id === $user->id;

        if (!($isAdmin || $isEmpresa || $isCandOwn)) {
            abort(403, 'No autorizado para ver este CV.');
        }

        // Asegúrate de haber ejecutado: php artisan storage:link
        $disk = Storage::disk('public');

        if (!$disk->exists($relative)) {
            abort(404, 'Archivo no encontrado.');
        }

        $path = $disk->path($relative);

        return response()->file($path, [
            'Content-Type'        => mime_content_type($path) ?: 'application/octet-stream',
            'Content-Disposition' => 'inline; filename="' . basename($relative) . '"',
        ]);
        // Si prefieres descarga:
        // return $disk->download($relative, basename($relative));
    }
}
