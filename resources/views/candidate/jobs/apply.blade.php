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
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3">
                    <h3 class="h5 mb-0 text-primary fw-semibold">Application Form</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('candidate.jobs.apply.store', $job->id) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Cover Letter -->
                        <div class="mb-4">
                            <label for="cover_letter" class="form-label fw-semibold">
                                {{ __('Cover Letter') }} <small class="text-muted">({{ __('Optional') }})</small>
                            </label>
                            <textarea id="cover_letter" name="cover_letter" class="form-control" rows="6" 
                                placeholder="{{ __('Explain why you are a good fit for this position...') }}">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <label for="contact_email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                                <input type="email" id="contact_email" name="contact_email" 
                                    class="form-control @error('contact_email') is-invalid @enderror" 
                                    value="{{ old('contact_email', auth()->user()->email) }}" required>
                                @error('contact_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label fw-semibold">
                                    {{ __('Phone Number') }} <small class="text-muted">({{ __('Optional') }})</small>
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" 
                                    class="form-control @error('contact_phone') is-invalid @enderror" 
                                    value="{{ old('contact_phone') }}"
                                    pattern="^[\d\s\+\-\(\)]{10,20}$">
                                <div class="form-text small">Format: +1234567890 or (123) 456-7890</div>
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Resume Upload -->
                        <div class="mb-4">
                            <label for="resume" class="form-label fw-semibold">{{ __('Upload Resume') }} <span class="text-danger">*</span></label>
                            <input type="file" id="resume" name="resume" 
                                class="form-control @error('resume') is-invalid @enderror" 
                                accept=".pdf,.doc,.docx" required>
                            <div class="form-text small">Accepted formats: PDF, DOC, DOCX (Max: 5MB)</div>
                            @error('resume')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-outline-secondary">
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
            <div class="card border-0 shadow-sm mt-4 rounded-3">
                <div class="card-body">
                    <h4 class="h6 fw-semibold mb-3 text-warning">
                        <i class="fas fa-lightbulb me-2"></i> Application Tips
                    </h4>
                    <ul class="list-unstyled mb-0">
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

<link rel="stylesheet" href="{{ asset('/style/apply.css') }}">


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validation bootstrap 5 style
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
