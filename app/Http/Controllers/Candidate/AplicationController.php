<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class AplicationController extends Controller
{
    public function store(Job $job)
    {
        abort_unless($job->status === 'open', 404);

        $candidate = Candidate::firstOrCreate(['user_id' => Auth::id()]);

        $exists = Application::where('candidate_id', $candidate->id)
            ->where('job_id', $job->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ya te postulaste a esta vacante.');
        }

        Application::create([
            'candidate_id' => $candidate->id,
            'job_id'       => $job->id,
            'status'       => 'applied',
            'score'        => null,
        ]);

        return back()->with('status', 'Postulación enviada.');
    }

}
