<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewJobPosted;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request ,$id)
    {
        $job= Job::find($id);
        return view('jobs.details', ['job'=>$job]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
{
    $validated = $request->validated();
    $employer = Auth::user()->employer;

    if (!$employer) {
        return back()->with('error', 'only available for employer to post a job');
    }

    $jobData = [
        'employer_id' => $employer->id,
        'title' => $validated['title'],
        'responsibilities' => $validated['responsibilities'],
        'skills' => json_encode($validated['skills']),
        'qualifications' => json_encode($validated['qualifications']),
        'salary_range' => json_encode([
            'min' => $validated['salary_range']['min'],
            'max' => $validated['salary_range']['max']
        ]),
        'experience_level_range' => json_encode([
            'min' => $validated['exp_range']['min'],
            'max' => $validated['exp_range']['max']
        ]),
        'country' => $validated['location']['country'],
        'benefits' => isset($validated['benefits']) ? json_encode($validated['benefits']) : null,
        'location' => json_encode([
            'address' => $validated['location']['address'],
            'city' => $validated['location']['city'],
            'state' => $validated['location']['state'],
            'country' => $validated['location']['country'],
            'postal_code' => $validated['location']['postal_code']
        ]),
        'work_type' => $validated['work_type'],
        'application_deadline' => $validated['application_deadline'],
    ];

    if ($request->hasFile('logo')) {
        $path = $request->file('logo')->store('company_logos', 'public');
        $jobData['logo'] = $path;
    }

    $job = Job::create($jobData);

    $candidates = User::where('user_type', 'candidate')->get();

    foreach ($candidates as $candidate) {
        $candidate->notify(new NewJobPosted($job));
    }

    return redirect()->route('jobs.show', $job->id)
        ->with('success', 'Job posted successfully and candidates notified!');
}

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        if (auth()->user()){
            $jobs = auth()->user()->jobs()->get();
            return view('employer.jobs', ['jobs' => $jobs]);
        }else{
            return view('employer.notRegister');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $job = Job::find($id);
        return view('employer.editJob', ['job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        $validated = $request->validated();
        $id= $request->route('id');
        $job=Job::find($id);
        if (!$job) {
            return back()->with('error', 'Job not found');
        }
        $employer = Auth::user()->employer;
        if (!$employer) {
            return back()->with('error', 'only available for employer to post a job');
        }
    
        $jobData = [
            'employer_id' => $employer->id,
            'title' => $validated['title'],
            'responsibilities' => $validated['responsibilities'],
            'skills' => json_encode($validated['skills']),
            'qualifications' => json_encode($validated['qualifications']),
            'salary_range' => json_encode([
                'min' => $validated['salary_range']['min'],
                'max' => $validated['salary_range']['max']
            ]),
            'experience_level_range' => json_encode([
                'min' => $validated['exp_range']['min'],
                'max' => $validated['exp_range']['max']
            ]),
            'country' => $validated['location']['country'],
            'benefits' => isset($validated['benefits']) ? json_encode($validated['benefits']) : null,
            'location' => json_encode([
                'address' => $validated['location']['address'],
                'city' => $validated['location']['city'],
                'state' => $validated['location']['state'],
                'country' => $validated['location']['country'],
                'postal_code' => $validated['location']['postal_code']
            ]),
            'work_type' => $validated['work_type'],
            'application_deadline' => $validated['application_deadline'],
        ];
    
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company_logos', 'public');
            $jobData['logo'] = $path;
        }
        $job->update($jobData);
        return redirect()->route('jobs.show', $job->id)
            ->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('employer.jobs')
            ->with('success', 'Job deleted successfully!');
    }
}
