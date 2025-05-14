@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h3 class="card-title fw-bold mb-4">Job Filters</h3>
                    <form method="GET" action="{{ route('candidate.jobs.index') }}">
                        <div class="mb-3">
                            <input type="text" name="keywords" class="form-control" placeholder="Keywords or Skills" value="{{ request('keywords') }}">
                        </div>

                        <div class="mb-3">
                            <select name="category" class="form-select">
                                <option value="">Select Category</option>
                                <option value="IT" {{ request('category') == 'IT' ? 'selected' : '' }}>Information Technology</option>
                                <option value="Marketing" {{ request('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select name="experience_level" class="form-select">
                                <option value="">Select Experience Level</option>
                                <option value="Entry" {{ request('experience_level') == 'Entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="Mid" {{ request('experience_level') == 'Mid' ? 'selected' : '' }}>Mid Level</option>
                                <option value="Senior" {{ request('experience_level') == 'Senior' ? 'selected' : '' }}>Senior Level</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select name="work_type" class="form-select">
                                <option value="">Select Work Type</option>
                                <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                <option value="on-site" {{ request('work_type') == 'on-site' ? 'selected' : '' }}>On-site</option>
                                <option value="hybrid" {{ request('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <input type="number" name="expected_salary" class="form-control" placeholder="Expected Salary ($)" value="{{ request('expected_salary') }}">
                        </div>

                        <div class="mb-3">
                            <select name="country" class="form-select" id="countries-select">
                                <option value="">Select Country</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Search Jobs</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if ($jobs->isEmpty())
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No jobs match your search criteria</h4>
                        <p class="text-muted">Try adjusting your filters or search for different keywords</p>
                    </div>
                </div>
            @else
                @foreach ($jobs as $job)
                    <div class="card mb-4 shadow-sm hover-shadow" style="transition: all 0.3s ease;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="h5 fw-bold">{{ $job->title }}</h3>
                                    <p class="text-muted mb-2"><strong>{{ strtoupper($job->employer->company_name) ?? 'Company not specified' }}</strong><br/>{{$job->employer->user->name ?? "No Employer Name"}}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $job->work_type == 'remote' ? 'info' : 'warning' }} text-white">
                                        {{ ucfirst(str_replace('-', ' ', $job->work_type ?? 'Not specified')) }}
                                    </span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i> 
                                        {{ json_decode($job->location, true)['city'] ?? 'City not specified' }}, {{ json_decode($job->location, true)['country'] ?? 'City not specified' }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><i class="fas fa-money-bill-wave me-2 text-primary"></i> 
                                        ${{ json_decode($job->salary_range, true)['min'] ?? 'Salary not specified' }} - ${{ json_decode($job->salary_range, true)['max'] ?? 'Salary not specified' }}
                                    </p>
                                    <p class="mb-1"><i class="fas fa-briefcase me-2 text-primary"></i> 
                                        {{ json_decode($job->experience_level_range, true)['min'] ?? 'Exp Min not specified' }} - {{ json_decode($job->experience_level_range, true)['max'] ?? 'Exp MAx not specified' }} Years
                                    </p>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge bg-light text-dark"><i class="fas fa-tag me-1"></i> {{ $job->category ?? 'Not specified' }}</span>
                                    <span class="badge bg-light text-dark"><i class="fas fa-clock me-1"></i> Dead Line: {{ $job->application_deadline ?? 'Not specified' }}</span>
                                </div>
                            </div>

                            <p class="mt-2">{{ Str::limit($job->description ?? '', 200) }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                <a href="{{ route('candidate.jobs.apply', $job->id) }}" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i> Apply Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

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

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    .card {
        border-radius: 0.5rem;
        border: none;
    }
    .form-select, .form-control {
        border-radius: 0.375rem;
    }
</style>
@endsection