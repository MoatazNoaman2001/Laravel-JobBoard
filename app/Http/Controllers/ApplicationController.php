<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\NewApplicationReceived;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Notification; 
use Illuminate\Http\Request;

class ApplicationController extends Controller
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
    public function create(Request $request)
    {
        $id = $request->route('job');
        $job = Job::find($id);
        return view('candidate.jobs.apply', ['job' => $job]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        $id = $request->route('job');
        $job = Job::find($id);
        if ($job->applications()->where('candidate_id', Auth::id())->exists()) {
            return redirect()->route('candidate.jobs.index', $job)
                   ->with('error', __('You have already applied for this job.'));
        }
    
        try {
            DB::beginTransaction();
    
            $applicationData = [
                'job_id' => $job->id,
                'candidate_id' => Auth::id(),
                'cover_letter' => $request->cover_letter,
                'contact_email' => $request->contact_email ?? Auth::user()->email,
                'contact_phone' => $request->contact_phone,
                'status' => Application::STATUS_PENDING,
                'applied_at' => now(),
            ];
    
            if ($request->hasFile('resume')) {
                $filename = 'resume_'.Auth::id().'_'.time().'.'.$request->resume->extension();
                $path = $request->file('resume')->storeAs('resumes', $filename, 'public');
                $applicationData['resume_path'] = $path;
                $applicationData['resume_filename'] = $request->file('resume')->getClientOriginalName();
            }
    
            $application = Application::create($applicationData);
    
            Notification::send(
                Auth::user(),
                new ApplicationSubmitted($job, $application)
            );
    
            if ($job->shouldNotifyEmployer()) {
                Notification::send(
                    $job->employer,
                    new NewApplicationReceived($job, $application)
                );
            }
            DB::commit();
    
            return redirect()->route('candidate.jobs.index')
                   ->with('success', __('Application submitted successfully!'));
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Application submission failed: '.$e->getMessage());
            
            // return back()->with('error', __('Failed to submit application. Please try again.'));
        }
    }

    public function updateStatus(Request $request){
        $jobId = $request->route('job');
        $applicationId = $request->route('application');


        $application = Application::find($applicationId);
        if (!$application) {
            return back()->with('error', 'Application not found');
        }
        $job = Job::find($jobId);
        if (!$job) {
            return back()->with('error', 'Job not found');
        }
        if ($application->job_id !== $job->id) {
            return back()->with('error', 'Application does not belong to this job');
        }

        $status = $request->input('status');
        if (!in_array($status, ['pending', 'reviewed', 'accepted', 'rejected'])) {
            return back()->with('error', 'Invalid status');
        }
        $application->status = $status;
        $application->save();
        return redirect()->route('jobs.index', $job)
            ->with('success', 'Application status updated successfully');
    } 
    public function updateNotes(Request $request){
        $jobId = $request->route('job');
        $applicationId = $request->route('application');


        $application = Application::find($applicationId);
        if (!$application) {
            return back()->with('error', 'Application not found');
        }
        $job = Job::find($jobId);
        if (!$job) {
            return back()->with('error', 'Job not found');
        }
        if ($application->job_id !== $job->id) {
            return back()->with('error', 'Application does not belong to this job');
        }

        $status = $request->input('notes');
        if (!in_array($status, ['pending', 'reviewed', 'accepted', 'rejected'])) {
            return back()->with('error', 'Invalid status');
        }
        $application->notes = $status;
        $application->save();
        return redirect()->route('jobs.index', $job)
            ->with('success', 'Application status updated successfully');    
    } 
    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $jobId = $request->route('job');
        $applicationId = $request->route('application');

        $application = Application::find($applicationId);
        if (!$application) {
            return back()->with('error', 'Application not found');
        }
        $job = Job::find($jobId);
        if (!$job) {
            return back()->with('error', 'Job not found');
        }
        if ($application->job_id !== $job->id) {
            return back()->with('error', 'Application does not belong to this job');
        }

        $application->delete();
        return redirect()->route('employer.applications', $jobId)
            ->with('success', 'Application deleted successfully');
    }
}
