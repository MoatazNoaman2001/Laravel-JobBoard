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
                    <form method="POST" action="{{ route('jobs.update', $job->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="mb-4">
                            <h5 class="mb-3">Basic Information</h5>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Job Title *</label>
                                <input type="text" value="{{$job->title}}" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="responsibilities" class="form-label">Responsibilities *</label>
                                <textarea class="form-control @error('responsibilities') is-invalid @enderror" 
                                          id="responsibilities" name="responsibilities" rows="4" required>{{ $job->responsibilities }}</textarea>
                                @error('responsibilities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Requirements</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Skills *</label>
                                <div id="skills-container">
                                    @php
                                        $skillsToDisplay = old('skills', 
                                            isset($job) && $job->skills ? json_decode($job->skills, true) : ['']
                                        );
                                    @endphp
                                    
                                    @foreach($skillsToDisplay as $skill)
                                        <div class="input-group mb-2 skill-input-group">
                                            <input type="text" 
                                                   class="form-control @error('skills.*') is-invalid @enderror" 
                                                   name="skills[]" 
                                                   value="{{ is_array($skill) ? $skill[0] ?? $skill : $skill }}">
                                            <button type="button" class="btn btn-outline-danger remove-skill">
                                                Remove
                                            </button>
                                            @error('skills.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-skill">
                                    <i class="fas fa-plus me-1"></i> Add Skill
                                </button>
                                @error('skills')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('add-skill').addEventListener('click', function() {
                                        const container = document.getElementById('skills-container');
                                        const newSkill = document.createElement('div');
                                        newSkill.className = 'input-group mb-2 skill-input-group';
                                        newSkill.innerHTML = `
                                            <input type="text" class="form-control" name="skills[]" placeholder="Enter skill">
                                            <button type="button" class="btn btn-outline-danger remove-skill">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        `;
                                        container.appendChild(newSkill);
                                    });
                            
                                    document.addEventListener('click', function(e) {
                                        if (e.target.classList.contains('remove-skill') || 
                                            e.target.closest('.remove-skill')) {
                                            const skillGroup = e.target.closest('.skill-input-group');
                                            if (skillGroup && document.querySelectorAll('.skill-input-group').length > 1) {
                                                skillGroup.remove();
                                            }
                                        }
                                    });
                                });
                            </script>
                            @endpush

                            <div class="mb-3">
                                <label class="form-label">Qualifications *</label>
                                <div id="qualifications-container">
                                    @php
                                        $qualificationsToDisplay = old('qualifications', 
                                            isset($job) && $job->qualifications ? json_decode($job->qualifications, true) : ['']
                                        );
                                    @endphp
                                    
                                    @foreach($qualificationsToDisplay as $index => $qualification)
                                        <div class="input-group mb-2 qualification-input-group">
                                            <input type="text" 
                                                   class="form-control @error("qualifications.$index") is-invalid @enderror" 
                                                   name="qualifications[]" 
                                                   value="{{ is_array($qualification) ? $qualification[0] ?? $qualification : $qualification }}"
                                                   placeholder="e.g. Bachelor's degree in Computer Science">
                                            <button type="button" class="btn btn-outline-danger remove-qualification">
                                                Remove
                                            </button>
                                            @error("qualifications.$index")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-qualification">
                                    <i class="fas fa-plus me-1"></i> Add Qualification
                                </button>
                                @error('qualifications')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('add-qualification').addEventListener('click', function() {
                                        const container = document.getElementById('qualifications-container');
                                        const newQualification = document.createElement('div');
                                        newQualification.className = 'input-group mb-2 qualification-input-group';
                                        newQualification.innerHTML = `
                                            <input type="text" class="form-control" name="qualifications[]" placeholder="e.g. 3+ years of experience">
                                            <button type="button" class="btn btn-outline-danger remove-qualification">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        `;
                                        container.appendChild(newQualification);
                                    });
                            
                                    document.addEventListener('click', function(e) {
                                        if (e.target.classList.contains('remove-qualification') || 
                                            e.target.closest('.remove-qualification')) {
                                            const qualGroup = e.target.closest('.qualification-input-group');
                                            if (qualGroup && document.querySelectorAll('.qualification-input-group').length > 1) {
                                                qualGroup.remove();
                                            }
                                        }
                                    });
                                });
                            </script>
                            @endpush
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Compensation & Benefits</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="salary_range_min" class="form-label">Minimum Salary *</label>
                                    <input type="number" class="form-control @error('salary_range.min') is-invalid @enderror" 
                                           id="salary_range_min" name="salary_range[min]" value="{{ json_decode($job->salary_range, true)['min'] }}" required>
                                    @error('salary_range.min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="salary_range_max" class="form-label">Maximum Salary *</label>
                                    <input type="number" class="form-control @error('salary_range.max') is-invalid @enderror" 
                                           id="salary_range_max" name="salary_range[max]" value="{{ json_decode($job->salary_range, true)['max'] }}" required>
                                    @error('salary_range.max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="exp_range_min" class="form-label">Minimum Experiance *</label>
                                    <input type="number" class="form-control @error('exp_range.min') is-invalid @enderror" 
                                           id="exp_range_min" name="exp_range[min]" value="{{ json_decode($job->experience_level_range, true)['min'] }}" required>
                                    @error('exp_range.min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exp_range_max" class="form-label">Maximum Experiance *</label>
                                    <input type="number" class="form-control @error('exp_range.max') is-invalid @enderror" 
                                           id="exp_range_max" name="exp_range[max]" value="{{ json_decode($job->experience_level_range, true)['max'] }}" required>
                                    @error('exp_range.max')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Benefits (Optional)</label>
                                <div id="benefits-container">
                                    @php
                                        $benefitsToDisplay = old('benefits', 
                                            isset($job) && $job->benefits ? json_decode($job->benefits, true) : ['']
                                        );
                                    @endphp
                                    @foreach($benefitsToDisplay as $benefit)
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="benefits[]" value="{{ $benefit }}">
                                            <button type="button" class="btn btn-outline-danger remove-benefit">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-benefit">Add Benefit</button>
                                @error('benefits')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Location & Type</h5>
                            
                            <div class="mb-3">
                                @php
                                    $location = old('location', isset($job) && $job->location ? json_decode($job->location, true) : []);
                                    $addressToDisplay = $location['address'] ?? '';
                                @endphp
                            
                                <label for="location_address" class="form-label">Address *</label>
                                <input type="text"
                                       value="{{ old('location.address', $addressToDisplay) }}"
                                       class="form-control @error('location.address') is-invalid @enderror"
                                       id="location_address"
                                       name="location[address]"
                                       required>
                                @error('location.address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                @php
                                    $cityToDisplay = $location['city'] ?? '';
                                @endphp
                            
                                <div class="col-md-6 mb-3">
                                    <label for="location_city" class="form-label">City *</label>
                                    <input type="text" value="{{$cityToDisplay}}" class="form-control @error('location.city') is-invalid @enderror" 
                                           id="location_city" name="location[city]" value="{{ old('location.city') }}" required>
                                    @error('location.city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    @php
                                        $countryToDisplay = $location['country'] ?? '';
                                    @endphp
                                    <label for="location_state" class="form-label">State/Province *</label>
                                    <input type="text" value="{{$countryToDisplay}}" class="form-control @error('location.state') is-invalid @enderror" 
                                           id="location_state" name="location[state]" value="{{ old('location.state') }}" required>
                                    @error('location.state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    @php
                                        $countryToDisplay = $location['country'] ?? '';
                                    @endphp
                                    <label for="location_country" class="form-label">Country *</label>
                                    <input type="text" value="{{$countryToDisplay}}" class="form-control @error('location.country') is-invalid @enderror" 
                                           id="location_country" name="location[country]" value="{{ old('location.country') }}" required>
                                    @error('location.country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    @php
                                        $postal_codeToDisplay = $location['postal_code'] ?? '';
                                    @endphp
                                    <label for="location_postal_code" class="form-label">Postal Code *</label>
                                    <input type="text" value="{{$postal_codeToDisplay}}" class="form-control @error('location.postal_code') is-invalid @enderror" 
                                           id="location_postal_code" name="location[postal_code]" value="{{ old('location.postal_code') }}" required>
                                    @error('location.postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="work_type" class="form-label">Work Type *</label>
                                <select class="form-select @error('work_type') is-invalid @enderror" id="work_type" name="work_type" required>
                                    @php
                                        $selectedWorkType = old('work_type', $job->work_type ?? '');
                                    @endphp
                            
                                    <option value="">Select Work Type</option>
                                    <option value="remote" {{ $selectedWorkType == 'remote' ? 'selected' : '' }}>Remote</option>
                                    <option value="on_site" {{ $selectedWorkType == 'on_site' ? 'selected' : '' }}>On Site</option>
                                    <option value="hybrid" {{ $selectedWorkType == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('work_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">Additional Information</h5>
                            
                            <div class="mb-3">
                                <label for="application_deadline" class="form-label">Application Deadline *</label>
                                <input type="date"
                                       class="form-control @error('application_deadline') is-invalid @enderror" 
                                       id="application_deadline"
                                       name="application_deadline"
                                       value="{{ old('application_deadline', isset($job) ? $job->application_deadline : '') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('application_deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            <div class="mb-3">
                                <label for="logo" class="form-label">Company Logo (Optional)</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" value="{{old('logo', isset($job) ? $job->logo : '') }}" name="logo" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Edit Job</button>
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