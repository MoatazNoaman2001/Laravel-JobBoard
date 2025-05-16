@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Admin Header -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); background-color: var(--primary); color: white;">
        <div class="card-body p-4">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div>
                    <h1 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0.5rem;">Admin Dashboard</h1>
                    <p style="opacity: 0.9; margin-bottom: 0;">Welcome, {{ auth()->user()->name }}</p>
                </div>
                <div>
                    <span style="background-color: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.875rem;">
                        <i class="fas fa-clock"></i> {{ now()->format('F j, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Navigation -->
    <div class="card mb-4" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);">
        <div class="card-body p-3">
            <div style="display: flex; gap: 0.5rem; overflow-x: auto;">
                <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color: var(--primary); color: white; border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a href="{{ route('admin.jobs') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-briefcase mr-2"></i> Jobs
                </a>
                <a href="{{ route('admin.applications') }}" class="btn" style="background-color: white; color: var(--gray-700); border: 1px solid var(--gray-300); border-radius: 0.375rem; padding: 0.5rem 1rem; font-weight: 500;">
                    <i class="fas fa-file-alt mr-2"></i> Applications
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); height: 100%; border-left: 4px solid #3b82f6;">
                <div class="card-body p-4">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <p style="color: var(--gray-500); font-size: 0.875rem; margin-bottom: 0.25rem;">Total Employers</p>
                            <h3 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0;">{{ $employersCount }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background-color: rgba(59, 130, 246, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-building" style="color: #3b82f6; font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); height: 100%; border-left: 4px solid #10b981;">
                <div class="card-body p-4">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <p style="color: var(--gray-500); font-size: 0.875rem; margin-bottom: 0.25rem;">Total Candidates</p>
                            <h3 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0;">{{ $candidatesCount }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background-color: rgba(16, 185, 129, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-tie" style="color: #10b981; font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); height: 100%; border-left: 4px solid #f59e0b;">
                <div class="card-body p-4">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <p style="color: var(--gray-500); font-size: 0.875rem; margin-bottom: 0.25rem;">Total Jobs</p>
                            <h3 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0;">{{ $jobsCount }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background-color: rgba(245, 158, 11, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-briefcase" style="color: #f59e0b; font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); height: 100%; border-left: 4px solid #ec4899;">
                <div class="card-body p-4">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <p style="color: var(--gray-500); font-size: 0.875rem; margin-bottom: 0.25rem;">Applications</p>
                            <h3 style="font-weight: 700; font-size: 1.75rem; margin-bottom: 0;">{{ $applicationsCount }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background-color: rgba(236, 72, 153, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-alt" style="color: #ec4899; font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pending Jobs Section -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); height: 100%;">
                <div class="card-header" style="background-color: white; border-bottom: 1px solid var(--gray-200); padding: 1rem 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Pending Job Approvals</h3>
                        <span class="badge" style="background-color: #f59e0b; color: white; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 2rem;">{{ $pendingJobs->count() }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($pendingJobs->isEmpty())
                        <div class="p-4 text-center" style="color: var(--gray-500);">
                            <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <p>No pending jobs to review.</p>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: var(--gray-100);">
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Job Title</th>
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Company</th>
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Posted</th>
                                        <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingJobs as $job)
                                        <tr style="border-bottom: 1px solid var(--gray-200);">
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->title }}</td>
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->employer->company_name }}</td>
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $job->created_at->diffForHumans() }}</td>
                                            <td style="padding: 0.75rem 1rem; text-align: right;">
                                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                                    <form action="{{ route('admin.job.approve', $job->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn" style="background-color: #10b981; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.job.reject', $job->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn" style="background-color: #ef4444; color: white; font-size: 0.75rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="card-footer" style="background-color: white; border-top: 1px solid var(--gray-200); padding: 0.75rem 1.25rem; text-align: center;">
                    <a href="{{ route('admin.jobs') }}" style="color: var(--primary); font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                        View All Jobs <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Users Section -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border: none; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); height: 100%;">
                <div class="card-header" style="background-color: white; border-bottom: 1px solid var(--gray-200); padding: 1rem 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-weight: 600; font-size: 1.25rem; margin: 0;">Recent Users</h3>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentUsers->isEmpty())
                        <div class="p-4 text-center" style="color: var(--gray-500);">
                            <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                            <p>No users registered yet.</p>
                        </div>
                    @else
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: var(--gray-100);">
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Name</th>
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Email</th>
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Type</th>
                                        <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--gray-700); font-size: 0.875rem;">Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr style="border-bottom: 1px solid var(--gray-200);">
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->name }}</td>
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->email }}</td>
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                                                @if($user->user_type == 'admin')
                                                    <span style="background-color: #8b5cf6; color: white; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Admin</span>
                                                @elseif($user->user_type == 'employer')
                                                    <span style="background-color: #3b82f6; color: white; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Employer</span>
                                                @else
                                                    <span style="background-color: #10b981; color: white; font-size: 0.75rem; padding: 0.125rem 0.5rem; border-radius: 0.25rem;">Candidate</span>
                                                @endif
                                            </td>
                                            <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">{{ $user->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="card-footer" style="background-color: white; border-top: 1px solid var(--gray-200); padding: 0.75rem 1.25rem; text-align: center;">
                    <a href="{{ route('admin.users') }}" style="color: var(--primary); font-weight: 500; font-size: 0.875rem; text-decoration: none;">
                        View All Users <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection