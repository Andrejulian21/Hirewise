<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use App\Models\Company;
use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function empresa()
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $jobsCount    = $company->jobs()->count();
        $openJobs     = $company->jobs()->where('status','open')->count();

        $jobIds = $company->jobs()->pluck('id');
        $appsCount   = Application::whereIn('job_id', $jobIds)->count();
        $avgScore    = round((float) Application::whereIn('job_id', $jobIds)->avg('score'), 2);

        $topJobs = Job::where('company_id', $company->id)
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->limit(5)->get(['id','title']);

        $lastApps = Application::whereIn('job_id',$jobIds)
            ->with(['candidate.user','job'])
            ->latest()->limit(5)->get();

        return view('empresa.dashboard', compact(
            'jobsCount','openJobs','appsCount','avgScore','topJobs','lastApps'
        ));
    }

    public function candidato()
    {
        $candidate = Candidate::firstOrCreate(['user_id' => Auth::id()]);

        $totalApps = $candidate->applications()->count();
        $avgScore  = round((float) $candidate->applications()->avg('score'), 2);

        $lastApps = $candidate->applications()
            ->with(['job.company'])
            ->latest()->limit(5)->get();

        return view('candidato.dashboard', compact('totalApps','avgScore','lastApps'));
    }
}