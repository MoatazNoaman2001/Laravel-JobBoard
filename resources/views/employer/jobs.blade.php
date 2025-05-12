@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Job Listing</h1>
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Post New Job
        </a>
    </div>

    @if($jobs->isEmpty())
        <div class="alert alert-info">
            You have never been posted any job yet.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Job Title</th>
                        <th>Applications</th>
                        <th>Posted Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>
                            <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none">
                                <strong>{{ $job->title }}</strong>
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-primary rounded-pill">
                                {{ $job->applications_count ?? 0 }}
                            </span>
                        </td>
                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($job->application_deadline->isPast())
                                <span class="badge bg-secondary">Closed</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('jobs.edit', $job) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jobs.destroy', $job) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this job?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection