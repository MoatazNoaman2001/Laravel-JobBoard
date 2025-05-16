@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container py-5">
    <div class="card shadow-sm rounded-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ $job->title ?? 'Job Title Not Available' }}</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">
                    <strong>Location (Country): </strong>
                    {{ $job->country ?? 'Not specified' }}
                </li>
                <li class="list-group-item">
                    <strong>Salary: </strong>
                    ${{ json_decode($job->salary_range, true)['min'] ?? 'Salary not specified' }} - ${{ json_decode($job->salary_range, true)['max'] ?? 'Salary not specified' }}
                    </li>
                <li class="list-group-item">
                    <strong>Experience Required: </strong>
                {{ json_decode($job->experience_level_range, true)['min'] ?? 'Exp Min not specified' }} - {{ json_decode($job->experience_level_range, true)['max'] ?? 'Exp MAx not specified' }} Years

                </li>
                <li class="list-group-item">
                    <strong>{{ strtoupper($job->employer->company_name) ?? 'Company not specified' }}: </strong>{{$job->employer->user->name ?? "No Employer Name"}}</li>
            </ul>

            <h5 class="mb-3">Responsibilities</h5>
            @if(!empty($job->responsibilities))
                <p style="white-space: pre-line;">{{ $job->responsibilities }}</p>
            @else
                <p class="text-muted">No responsibilities specified.</p>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</small>
                                <a href="{{ route('candidate.jobs.apply', $job->id) }}" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i> Apply Now
                                </a>
                            </div>
</div>
@endsection
