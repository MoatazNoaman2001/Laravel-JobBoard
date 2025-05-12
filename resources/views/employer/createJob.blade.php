@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Post a New Job</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('jobs.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5 class="mb-3">Basic Information</h5>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Job Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="responsibilities" class="form-label">Responsibilities *</label>
                                <textarea class="form-control @error('responsibilities') is-invalid @enderror" 
                                          id="responsibilities" name="responsibilities" rows="4" required>{{ old('responsibilities') }}</textarea>
                                @error('responsibilities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Skills & Qualifications -->
                        <div class="mb-4">
                            <h5 class="mb-3">Requirements</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Skills *</label>
                                <div id="skills-container">
                                    @if(old('skills'))
                                        @foreach(old('skills') as $skill)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="skills[]" value="{{ $skill }}">
                                                <button type="button" class="btn btn-outline-danger remove-skill">Remove</button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="skills[]">
                                            <button type="button" class="btn btn-outline-danger remove-skill">Remove</button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-skill">Add Skill</button>
                                @error('skills')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Qualifications *</label>
                                <div id="qualifications-container">
                                    @if(old('qualifications'))
                                        @foreach(old('qualifications') as $qualification)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="qualifications[]" value="{{ $qualification }}">
                                                <button type="button" class="btn btn-outline-danger remove-qualification">Remove</button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="qualifications[]">
                                            <button type="button" class="btn btn-outline-danger remove-qualification">Remove</button>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-qualification">Add Qualification</button>
                                @error('qualifications')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Salary & Benefits -->
                        <div class="mb-4">
                            <h5 class="mb-3">Compensation & Benefits</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="salary_range_min" class="form-label">Minimum Salary *</label>
                                    <input type="number" class="form-control @error('salary_range.min') is-invalid @enderror" 
                                           id="salary_range_min" name="salary_range[min]" value="{{ old('salary_range.min') }}" required>
                                    @error('salary_range.min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="salary_range_max" class="form-label">Maximum Salary *</label>
                                    <input type="number" class="form-control @error('salary_range.max') is-invalid @enderror" 
                                           id="salary_range_max" name="salary_range[max]" value="{{ old('salary_range.max') }}" required>
                                    @error('salary_range.max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Benefits (Optional)</label>
                                <div id="benefits-container">
                                    @if(old('benefits'))
                                        @foreach(old('benefits') as $benefit)
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" name="benefits[]" value="{{ $benefit }}">
                                                <button type="button" class="btn btn-outline-danger remove-benefit">Remove</button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-benefit">Add Benefit</button>
                                @error('benefits')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Location & Work Type -->
                        <div class="mb-4">
                            <h5 class="mb-3">Location & Type</h5>
                            
                            <div class="mb-3">
                                <label for="location_address" class="form-label">Address *</label>
                                <input type="text" class="form-control @error('location.address') is-invalid @enderror" 
                                       id="location_address" name="location[address]" value="{{ old('location.address') }}" required>
                                @error('location.address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="location_city" class="form-label">City *</label>
                                    <input type="text" class="form-control @error('location.city') is-invalid @enderror" 
                                           id="location_city" name="location[city]" value="{{ old('location.city') }}" required>
                                    @error('location.city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="location_state" class="form-label">State/Province *</label>
                                    <input type="text" class="form-control @error('location.state') is-invalid @enderror" 
                                           id="location_state" name="location[state]" value="{{ old('location.state') }}" required>
                                    @error('location.state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="location_country" class="form-label">Country *</label>
                                    <input type="text" class="form-control @error('location.country') is-invalid @enderror" 
                                           id="location_country" name="location[country]" value="{{ old('location.country') }}" required>
                                    @error('location.country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="location_postal_code" class="form-label">Postal Code *</label>
                                    <input type="text" class="form-control @error('location.postal_code') is-invalid @enderror" 
                                           id="location_postal_code" name="location[postal_code]" value="{{ old('location.postal_code') }}" required>
                                    @error('location.postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="work_type" class="form-label">Work Type *</label>
                                <select class="form-select @error('work_type') is-invalid @enderror" id="work_type" name="work_type" required>
                                    <option value="">Select Work Type</option>
                                    <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                    <option value="on_site" {{ old('work_type') == 'on_site' ? 'selected' : '' }}>On Site</option>
                                    <option value="hybrid" {{ old('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('work_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Application Deadline & Logo -->
                        <div class="mb-4">
                            <h5 class="mb-3">Additional Information</h5>
                            
                            <div class="mb-3">
                                <label for="application_deadline" class="form-label">Application Deadline *</label>
                                <input type="date" class="form-control @error('application_deadline') is-invalid @enderror" 
                                       id="application_deadline" name="application_deadline" 
                                       value="{{ old('application_deadline') }}" min="{{ date('Y-m-d') }}" required>
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Company Logo (Optional)</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" name="logo" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Post Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-skill').addEventListener('click', function() {
        const container = document.getElementById('skills-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="skills[]">
            <button type="button" class="btn btn-outline-danger remove-skill">Remove</button>
        `;
        container.appendChild(div);
    });

    document.getElementById('add-qualification').addEventListener('click', function() {
        const container = document.getElementById('qualifications-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="qualifications[]">
            <button type="button" class="btn btn-outline-danger remove-qualification">Remove</button>
        `;
        container.appendChild(div);
    });

    document.getElementById('add-benefit').addEventListener('click', function() {
        const container = document.getElementById('benefits-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="benefits[]">
            <button type="button" class="btn btn-outline-danger remove-benefit">Remove</button>
        `;
        container.appendChild(div);
    });
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-skill')) {
            e.target.closest('.input-group').remove();
        }
        if (e.target.classList.contains('remove-qualification')) {
            e.target.closest('.input-group').remove();
        }
        if (e.target.classList.contains('remove-benefit')) {
            e.target.closest('.input-group').remove();
        }
    });
</script>
@endsection