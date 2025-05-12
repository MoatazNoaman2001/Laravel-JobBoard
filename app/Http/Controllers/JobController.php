<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Models\Employer;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $ips = $request->ips();
        print_r($ips);
        $data = $request->all();
        print_r($data);
        $name = $request->query('best movie');
        $validated = $request->validated();
        print_r($validated);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('company_logos', 'public');
            $jobData['logo'] = $path;
        }

        $jobData = [
            'employer_id' => Auth::id(),
            'title' => $validated['title'],
            'responsibilities' => $validated['responsibilities'],
            'skills' => $validated['skills'],
            'qualifications' => $validated['qualifications'],
            'salary_range' => [
                'min' => $validated['salary_range']['min'],
                'max' => $validated['salary_range']['max']
            ],
            'benefits' => $validated['benefits'] ?? null,
            'location' => [
                'address' => $validated['location']['address'],
                'city' => $validated['location']['city'],
                'state' => $validated['location']['state'],
                'country' => $validated['location']['country'],
                'postal_code' => $validated['location']['postal_code']
            ],
            'work_type' => $validated['work_type'],
            'application_deadline' => $validated['application_deadline'],
        ];

        $job = Job::create($jobData);

        return redirect()->route('jobs.show', $job->id)
            ->with('success', 'Job posted successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $jobs = auth()->user()->jobs();
        return view('employer.jobs', ['jobs' => $jobs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
