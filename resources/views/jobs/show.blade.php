@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Job Posted Successfully</h4>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($job->logo)
                            <img src="{{ asset('storage/' . $job->logo) }}" alt="Company Logo" class="img-fluid rounded" style="max-height: 100px;">
                        @endif
                        <h2 class="mt-3">{{ $job->title }}</h2>
                        <p class="text-muted">{{ $job->employer->name }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Job Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Work Type:</strong> {{ ucfirst(str_replace('_', ' ', $job->work_type)) }}</p>
                                <p><strong>Location:</strong> 
                                    {{ $job->location['address'] }}, {{ $job->location['city'] }}, 
                                    {{ $job->location['state'] }}, {{ $job->location['country'] }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Salary Range:</strong> 
                                    ${{ number_format($job->salary_range['min']) }} - ${{ number_format($job->salary_range['max']) }}
                                </p>
                                <p><strong>Application Deadline:</strong> 
                                    {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Responsibilities</h5>
                        <p>{!! nl2br(e($job->responsibilities)) !!}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Skills Required</h5>
                            <ul>
                                @foreach($job->skills as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Qualifications</h5>
                            <ul>
                                @foreach($job->qualifications as $qualification)
                                    <li>{{ $qualification }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if($job->benefits)
                    <div class="mb-4">
                        <h5>Benefits</h5>
                        <ul>
                            @foreach($job->benefits as $benefit)
                                <li>{{ $benefit }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('jobs.create') }}" class="btn btn-primary me-md-2">Post Another Job</a>
                        <a href="#" class="btn btn-success">View Job Applications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection