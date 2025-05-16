<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employer;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{


    public function dashboard()
    {
        $employersCount = Employer::count();
        $candidatesCount = Candidate::count();
        $jobsCount = Job::count();
        $applicationsCount = Application::count();
        $pendingJobs = Job::where('status', 'pending')->get();
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentJobs = Job::with('employer')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard_new', compact(
            'employersCount',
            'candidatesCount',
            'jobsCount',
            'applicationsCount',
            'pendingJobs',
            'recentUsers',
            'recentJobs'
        ));
    }

    public function users(Request $request)
    {
        $query = User::with(['employer', 'candidate']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('type') && !empty($request->type)) {
            $query->where('user_type', $request->type);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        $users->appends($request->all());

        return view('admin.users_new', compact('users'));
    }

    public function jobs(Request $request)
    {
        $query = Job::with('employer');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhereHas('employer', function($q) use ($search) {
                      $q->where('company_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);

        $jobs->appends($request->all());

        return view('admin.jobs_new', compact('jobs'));
    }

    public function approveJob($id)
    {
        $job = Job::findOrFail($id);
        $job->status = 'approved';
        $job->save();

        return redirect()->back()->with('success', 'Job approved successfully.');
    }

    public function rejectJob($id)
    {
        $job = Job::findOrFail($id);
        $job->status = 'rejected';
        $job->save();

        return redirect()->back()->with('success', 'Job rejected successfully.');
    }

    public function deleteJob($id)
    {
        $job = Job::findOrFail($id);

        // Check if there are applications for this job
        $applicationsCount = $job->applications()->count();
        if ($applicationsCount > 0) {
            return redirect()->back()->with('error', 'Cannot delete job with existing applications. There are ' . $applicationsCount . ' applications for this job.');
        }

        $job->delete();
        return redirect()->route('admin.jobs')->with('success', 'Job deleted successfully.');
    }

    public function getUserDetails($id)
    {
        $user = User::with(['employer', 'candidate'])->findOrFail($id);
        return response()->json($user);
    }

    public function getJobDetails($id)
    {
        $job = Job::with(['employer'])->findOrFail($id);
        $job->applications_count = $job->applications()->count();
        return response()->json($job);
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent toggling admin status if it's the only admin
        if ($user->user_type === 'admin') {
            $adminCount = User::where('user_type', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->back()->with('error', 'Cannot disable the only admin account.');
            }
        }

        // Prevent toggling own status
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change your own status.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "User {$status} successfully.");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting the only admin
        if ($user->user_type === 'admin') {
            $adminCount = User::where('user_type', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->back()->with('error', 'Cannot delete the only admin account.');
            }
        }

        // Begin transaction to ensure all related data is deleted
        DB::beginTransaction();

        try {
            // Delete related data based on user type
            if ($user->user_type === 'employer') {
                // Check if employer has jobs with applications
                $jobsWithApplications = Job::where('employer_id', $user->employer->id)
                    ->whereHas('applications')
                    ->count();

                if ($jobsWithApplications > 0) {
                    return redirect()->back()->with('error', 'Cannot delete employer with active job applications.');
                }

                // Delete all jobs posted by this employer
                Job::where('employer_id', $user->employer->id)->delete();

                // Delete employer profile
                $user->employer()->delete();
            } elseif ($user->user_type === 'candidate') {
                // Delete all applications by this candidate
                Application::where('candidate_id', $user->candidate->id)->delete();

                // Delete candidate profile
                $user->candidate()->delete();
            }

            // Delete the user
            $user->delete();

            DB::commit();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while deleting the user: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of the applications.
     */
    public function applications(Request $request)
    {
        $query = Application::with(['job', 'candidate.user']); // This assumes Application has candidate() relationship
    
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('job', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })->orWhereHas('candidate.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }
        // Rest of your code remains the same...
        $applications = $query->orderBy('created_at', 'desc')->paginate(10);
        $jobs = Job::orderBy('title')->get();
        
        return view('admin.applications_new', compact('applications', 'jobs'));
    }
    /**
     * Display the specified application.
     */
    public function getApplicationDetails($id)
    {
        $application = Application::with(['job.employer', 'candidate.user'])->findOrFail($id);
        return response()->json($application);
    }

    /**
     * Update the status of an application.
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $application = Application::findOrFail($id);
        $application->status = $request->status;

        if ($request->has('notes')) {
            $application->notes = $request->notes;
        }

        $application->save();

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Delete an application.
     */
    public function deleteApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return redirect()->route('admin.applications')->with('success', 'Application deleted successfully.');
    }
}