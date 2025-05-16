@extends('layouts.app')

@section('title', 'Available Jobs')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Filters - Fixed -->
        <div class="col-md-3">
            <div class="card shadow-sm sticky-top" style="top: 80px; z-index: 100;">
                <div class="card-body p-4">
                    <h3 class="card-title fw-bold mb-4 text-dark">Job Filters</h3>
                    <form method="GET" action="{{ route('candidate.jobs.index') }}">
                        <div class="mb-3">
                            <input type="text" name="keywords" class="form-control rounded-lg border-gray-300 focus:ring-primary focus:border-primary" placeholder="Keywords or Skills" value="{{ request('keywords') }}">
                        </div>

                        <div class="mb-3">
                            <select name="category" class="form-select rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                <option value="">Select Category</option>
                                <option value="IT" {{ request('category') == 'IT' ? 'selected' : '' }}>Information Technology</option>
                                <option value="Marketing" {{ request('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select name="experience_level" class="form-select rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                <option value="">Select Experience Level</option>
                                <option value="Entry" {{ request('experience_level') == 'Entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="Mid" {{ request('experience_level') == 'Mid' ? 'selected' : '' }}>Mid Level</option>
                                <option value="Senior" {{ request('experience_level') == 'Senior' ? 'selected' : '' }}>Senior Level</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select name="work_type" class="form-select rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                                <option value="">Select Work Type</option>
                                <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                <option value="on-site" {{ request('work_type') == 'on-site' ? 'selected' : '' }}>On-site</option>
                                <option value="hybrid" {{ request('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <input type="number" name="expected_salary" class="form-control rounded-lg border-gray-300 focus:ring-primary focus:border-primary" placeholder="Expected Salary ($)" value="{{ request('expected_salary') }}">
                        </div>

                        <div class="mb-3">
                            <select name="country" class="form-select rounded-lg border-gray-300 focus:ring-primary focus:border-primary" id="countries-select">
                                <option value="">Select Country</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-lg py-2">Search Jobs</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Jobs Grid -->
        <div class="col-md-9">
            @if ($jobs->isEmpty())
                <div class="card shadow-md p-5 text-center rounded-lg">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No jobs match your search criteria</h4>
                    <p class="text-muted">Try adjusting your filters or search for different keywords</p>
                </div>
            @else
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach ($jobs as $job)
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

                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('/style/index.css') }}">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch("https://restcountries.com/v3.1/all")
            .then(res => res.json())
            .then(data => {
                let countrySelect = document.getElementById("countries-select");
                data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                
                const selectedCountry = "{{ request('country') }}";
                
                data.forEach(country => {
                    let option = document.createElement("option");
                    option.value = country.name.common;
                    option.text = country.name.common;
                    if (selectedCountry && selectedCountry === country.name.common) {
                        option.selected = true;
                    }
                    countrySelect.appendChild(option);
                });
            })
            .catch(err => console.error("Error loading countries:", err));
    });
</script>


@endsection