@extends('layouts.app')

@section('header')
<div class="container py-4">
    <h1 class="text-center display-5 fw-bold mb-4">
        {{ __('Apply for :job_title', ['job_title' => $job->title]) }}
    </h1>
    <div class="text-center">
        <p class="lead text-muted">{{ $job->company }} • {{ $job->location }}</p>
    </div>
</div>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-white py-3">
                    <h3 class="h5 mb-0">Application Form</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('candidate.jobs.apply.store', $job->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Cover Letter -->
                        <div class="mb-4">
                            <label for="cover_letter" class="form-label fw-bold">
                                {{ __('Cover Letter') }} <span class="text-muted">({{ __('Optional') }})</span>
                            </label>
                            <textarea id="cover_letter" name="cover_letter" class="form-control" rows="6" 
                                placeholder="{{ __('Explain why you are a good fit for this position...') }}">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="contact_email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                                <input type="email" id="contact_email" name="contact_email" 
                                    class="form-control @error('contact_email') is-invalid @enderror" 
                                    value="{{ old('contact_email', auth()->user()->email) }}" required>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label fw-bold">
                                    {{ __('Phone Number') }} <span class="text-muted">({{ __('Optional') }})</span>
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" 
                                    class="form-control @error('contact_phone') is-invalid @enderror" 
                                    value="{{ old('contact_phone') }}"
                                    pattern="^[\d\s\+\-\(\)]{10,20}$">
                                <small class="form-text text-muted">Format: +1234567890 or (123) 456-7890</small>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Resume Upload -->
                        <div class="mb-4">
                            <label for="resume" class="form-label fw-bold">{{ __('Upload Resume') }} <span class="text-danger">*</span></label>
                            <div class="file-upload-wrapper">
                                <input type="file" id="resume" name="resume" 
                                    class="form-control @error('resume') is-invalid @enderror" 
                                    accept=".pdf,.doc,.docx" required>
                                <div class="form-text">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</div>
                                @error('resume')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i> {{ __('Submit Application') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Application Tips -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h4 class="h6 fw-bold mb-3"><i class="fas fa-lightbulb text-warning me-2"></i> Application Tips</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Tailor your cover letter to this specific position</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Highlight relevant skills and experience</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Double-check your contact information</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Ensure your resume is up-to-date</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .file-upload-wrapper {
        position: relative;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    .card {
        border-radius: 0.5rem;
    }
    .was-validated .form-control:invalid, .form-control.is-invalid {
        background-position: right calc(0.375em + 2.5rem) center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Phone number formatting
        const phoneInput = document.getElementById('contact_phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                const x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            });
        }
    });
</script>
@endsection