<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobPostingController extends Controller
{
    // Mostrar todas las vacantes de la empresa autenticada
    public function index()
    {
        $user = Auth::user();
        $jobPostings = JobPosting::where('company_id', $user->company_id)->get();

        return response()->json($jobPostings);
    }

    // Crear una nueva vacante
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'description' => 'required|string',
            'skills' => 'nullable|array',
            'requirements' => 'nullable|array',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'currency' => 'nullable|string|max:10',
            'status' => 'nullable|in:draft,published,paused,closed',
            'published_at' => 'nullable|date',
            'closed_at' => 'nullable|date',
            'source' => 'nullable|string|max:80',
            'settings' => 'nullable|json',
        ]);

        $user = Auth::user();


        $jobPosting = JobPosting::create([
            'id' => (string) Str::ulid(),
            'company_id' => $user->company_id,
            'created_by' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'skills' => json_encode($request->skills),
            'requirements' => json_encode($request->requirements),
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'currency' => $request->currency,
            'status' => $request->status ?? 'draft',
            'published_at' => $request->published_at ?? now(),
            'closed_at' => $request->closed_at,
            'source' => $request->source,
            'settings' => json_encode($request->settings),
        ]);

        return response()->json([
            'message' => 'Vacante creada con éxito',
            'job' => $jobPosting
        ], 201);
    }

    // Ver una vacante específica
    public function show($id)
    {
        $jobPosting = JobPosting::findOrFail($id);
        return response()->json($jobPosting);
    }

    // Actualizar una vacante
    public function update(Request $request, $id)
    {
        // Buscar vacante por ID
        $jobPosting = JobPosting::findOrFail($id);

        // Validación de los datos actualizados
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'description' => 'required|string',
            'skills' => 'nullable|array',
            'requirements' => 'nullable|array',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'currency' => 'nullable|string|max:10',
            'status' => 'nullable|in:draft,published,paused,closed',
            'published_at' => 'nullable|date',
            'closed_at' => 'nullable|date',
            'source' => 'nullable|string|max:80',
            'settings' => 'nullable|json',
        ]);

        // Actualizar vacante
        $jobPosting->update([
            'title' => $request->title,
            'description' => $request->description,
            'skills' => json_encode($request->skills),
            'requirements' => json_encode($request->requirements),
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'currency' => $request->currency,
            'status' => $request->status ?? 'draft',
            'published_at' => $request->published_at ?? now(),
            'closed_at' => $request->closed_at,
            'source' => $request->source,
            'settings' => json_encode($request->settings),
        ]);

        return response()->json(['message' => 'Vacante actualizada', 'job' => $jobPosting]);
    }

    // Eliminar una vacante (soft delete)
    public function destroy($id)
    {
        $jobPosting = JobPosting::findOrFail($id);
        $jobPosting->delete();

        return response()->json(['message' => 'Vacante eliminada correctamente']);
    }
}
