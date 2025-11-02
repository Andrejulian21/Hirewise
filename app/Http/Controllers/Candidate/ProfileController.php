<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCandidateProfileRequest;
use App\Models\Candidate;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $candidate = Candidate::firstOrCreate(['user_id' => Auth::id()]);
        return view('candidato.perfil.edit', compact('candidate'));
    }

    public function update(UpdateCandidateProfileRequest $request)
    {
        $candidate = Candidate::firstOrCreate(['user_id' => Auth::id()]);
        $data = $request->validated();

        if ($request->hasFile('cv_file')) {
            // asegúrate de tener el enlace de storage
            // php artisan storage:link
            $data['cv_file'] = $request->file('cv_file')->store('cv', 'public');
        }

        $candidate->fill($data);
        $candidate->save();

        return back()->with('status', 'Perfil actualizado.');
    }
}
