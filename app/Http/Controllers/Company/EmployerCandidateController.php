<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Candidate;

class EmployerCandidateController extends Controller
{
    public function show(Candidate $candidate)
    {
        // Carga relaciones útiles
        $candidate->load(['user','skills']);
        return view('empresa.candidatos.show', compact('candidate'));
    }
}