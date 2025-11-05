<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCandidateProfileRequest;
use App\Models\Candidate;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function show()
    {
        $candidate = \App\Models\Candidate::firstOrCreate(['user_id' => Auth::id()]);
        return view('candidatos.perfil', compact('candidate')); // usa tu vista de perfil (read-only)
    }
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

            $data['cv_file'] = $request->file('cv_file')->store('cv', 'public');
        }

        if ($request->hasFile('photo')) {
            if ($candidate->photo_path) {
                Storage::disk('public')->delete($candidate->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('avatars', 'public');
        }

        $candidate->fill($data);
        $candidate->save();

        return redirect()
            ->route('candidato.perfil.show')
            ->with('status', 'Perfil actualizado.');
    }
}
