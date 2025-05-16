@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container-fluid p-0">

    <!-- Featured Jobs Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold text-dark">Featured Jobs</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($latestJobs as $job)
                <div class="col">
                            <div class="card h-100 shadow-md hover:shadow-lg rounded-lg transition-all duration-300" style="border: none;">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h3 class="h5 fw-bold text-dark">{{ $job->title }}</h3>
                                            <p class="text-muted mb-0"><strong>{{ strtoupper($job->employer->company_name ?? 'Company not specified') }}</strong><br>{{ $job->employer->user->name ?? 'No Employer Name' }}</p>
                                        </div>
                                        <span class="badge {{ $job->work_type == 'remote' ? 'bg-info' : ($job->work_type == 'hybrid' ? 'bg-warning' : 'bg-success') }} text-white rounded-pill px-3 py-1">
                                            {{ ucfirst(str_replace('-', ' ', $job->work_type ?? 'Not specified')) }}
                                        </span>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <p class="mb-1 text-dark"><i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                                {{ json_decode($job->location, true)['city'] ?? 'N/A' }}, {{ json_decode($job->location, true)['country'] ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-1 text-dark"><i class="fas fa-dollar-sign me-2 text-primary"></i>
                                                ${{ json_decode($job->salary_range, true)['min'] ?? 'N/A' }} - ${{ json_decode($job->salary_range, true)['max'] ?? 'N/A' }}
                                            </p>
                                            <p class="mb-1 text-dark"><i class="fas fa-briefcase me-2 text-primary"></i>
                                                {{ json_decode($job->experience_level_range, true)['min'] ?? 'N/A' }} - {{ json_decode($job->experience_level_range, true)['max'] ?? 'N/A' }} Years
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            <span class="badge bg-light text-dark rounded-pill px-2 py-1"><i class="fas fa-tag me-1 text-primary"></i> {{ $job->category ?? 'Not specified' }}</span>
                                            <span class="badge bg-light text-dark rounded-pill px-2 py-1"><i class="fas fa-clock me-1 text-primary"></i> Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M, Y') ?? 'N/A' }}</span>
                                        </div>
                                    </div>

                                    <p class="text-muted">{{ Str::limit($job->description ?? '', 200) }}</p>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                        <a href="{{ route('candidate.jobs.apply', $job->id) }}" class="btn btn-success rounded-pill px-3">
                                            <i class="fas fa-paper-plane me-2"></i> Apply Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">View All Jobs</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="fw-bold text-dark mb-4">About Us</h2>
                    <p class="text-secondary mb-4">We are dedicated to connecting talented individuals with the best job opportunities worldwide. Our platform offers a seamless experience for job seekers and employers alike, with advanced filters and real-time updates.</p>
                    <a href="{{ route('about') }}" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">Learn More</a>
                </div>
                <div class="col-md-6 text-center">
                    <i class="fas fa-users fa-6x text-primary"></i>
                </div>
            </div>
        </div>
    </section>



</div>
<link rel="stylesheet" href="{{ asset('/style/index.css') }}">
@endsection
