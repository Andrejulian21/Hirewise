<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class JobController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    // Mis vacantes (empresa)
    public function index()
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        $jobs = $company->jobs()->latest()->paginate(10);

        return view('empresa.jobs.index', compact('jobs'));
    }

    // Público
    public function publicIndex()
    {
        $jobs = Job::with('company')->where('status', 'open')->latest()->paginate(10);
        return view('empresa.jobs.public-index', compact('jobs'));
    }

    public function publicShow(Job $job)
    {
        abort_unless($job->status === 'open', 404);
        $job->load('company');
        return view('empresa.jobs.show', compact('job'));
    }

    public function create()
    {
        return view('empresa.jobs.create');
    }

    public function store(StoreJobRequest $request)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        $company->jobs()->create($request->validated());

        return to_route('empresa.jobs.index')->with('status', 'Vacante creada.');
    }


    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        return view('empresa.jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $this->authorize('update', $job);
        $job->update($request->validated());

        return redirect()->route('empresa.jobs.index')->with('status', 'Vacante actualizada.');
    }

    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        if (request()->boolean('force')) {
            // Borrado físico en DB
            $job->forceDelete();
            return back()->with('status', 'Vacante eliminada.');
        }

        // Borrado lógico (soft delete)
        $job->delete();
        return back()->with('status', 'Vacante eliminada (papelera).');
    }
}
