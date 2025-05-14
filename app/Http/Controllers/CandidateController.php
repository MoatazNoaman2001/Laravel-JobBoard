<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CandidateController extends Controller
{
    public function searchJobs(Request $request)
    {
        $query = Job::query();

        if ($request->filled('keywords')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keywords . '%')
                  ->orWhere('description', 'like', '%' . $request->keywords . '%')
                  ->orWhere('company', 'like', '%' . $request->keywords . '%');
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        $jobs = $query->paginate(10);

        return view('candidate.jobs.index', compact('jobs'));
    }

    public function showApplyForm(Job $job)
    {
        return view('candidate.jobs.apply', compact('job'));
    }

    public function applyJob(Request $request, Job $job)
    {
        $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'resume' => ['required_without:contact_email', 'nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'contact_email' => ['required_without:resume', 'email'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
        ]);

        if ($job->applications()->where('candidate_id', Auth::id())->exists()) {
            return redirect()->route('candidate.jobs.index')->with('error', 'You have already applied for this job.');
        }

        $applicationData = [
            'job_id' => $job->id,
            'candidate_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'status' => 'pending',
        ];

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $applicationData['resume_path'] = $path;
        }

        Application::create($applicationData);

        Auth::user()->notify(new \App\Notifications\ApplicationSubmitted($job));

        return redirect()->route('candidate.jobs.index')->with('success', 'Application submitted successfully!');
    }

    public function applications()
    {
        $applications = Auth::user()->applications()->with('job')->paginate(10);
        return view('candidate.applications', compact('applications'));
    }

    public function cancelApplication(Application $application)
    {
        if ($application->candidate_id === Auth::id() && $application->status === 'pending') {
            $application->delete();
            return redirect()->route('candidate.applications')->with('success', 'Application cancelled successfully!');
        }

        return redirect()->route('candidate.applications')->with('error', 'This application cannot be cancelled.');
    }

    public function settings()
    {
        return view('candidate.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('candidate.settings')->with('success', 'Settings updated successfully!');
    }

    public function register(Request $request)
    {
        // $request->validated();

        try{
            DB::transaction(function() use($request) {
                $existingUser = User::where('email', $request->email)->first();
        
                if ($existingUser) {
                    Candidate::where('user_id', $existingUser->id)->delete();
                    $existingUser->delete();
                }
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'user_type' => 'candidate',
                ]);
        
                $condidate = Candidate::create([
                    'user_id' => $user->id,
                    'phone' => $request->phone,
                    'location' => $request->location,
                    'experience_level' => $request->experience_level,
                    'work_type' => $request->work_type,
                ]);
                Auth::login($user);
            });
            return redirect()->route('candidate.jobs.index')->with('success', 'Registration successful!');
        }catch(Exception $e){
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}