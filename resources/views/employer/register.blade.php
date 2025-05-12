@extends('layouts.app')

@section('title', 'Employer Registration')

@section('content')
<div class="card rounded-lg shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Employer Registration</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('register.employer') }}" enctype="multipart/form-data">
            @csrf

            <!-- Account Information -->
            <fieldset class="mb-5">
                <legend class="h5 text-primary border-bottom pb-2">Account Information</legend>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-5">
                <legend class="h5 text-primary border-bottom pb-2">Company Information</legend>

                <div class="row g-3">
                    <div class="col-12">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                               id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Company Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="logo" class="form-label">Company Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" name="logo" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <img src="#" alt="Logo Preview" class="mt-2 company-logo-preview" id="logoPreview">
                    </div>

                    <div class="col-md-6">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror" 
                               id="website" name="website" value="{{ old('website') }}" placeholder="https://">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="industry" class="form-label">Industry</label>
                        <select class="form-select @error('industry') is-invalid @enderror" 
                                id="industry" name="industry">
                            <option value="">Select Industry</option>
                            <option value="Technology" @selected(old('industry') == 'Technology')>Technology</option>
                            <option value="Finance" @selected(old('industry') == 'Finance')>Finance</option>
                            <option value="Healthcare" @selected(old('industry') == 'Healthcare')>Healthcare</option>
                            <option value="Education" @selected(old('industry') == 'Education')>Education</option>
                            <option value="Manufacturing" @selected(old('industry') == 'Manufacturing')>Manufacturing</option>
                        </select>
                        @error('industry')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="company_size" class="form-label">Company Size</label>
                        <select class="form-select @error('company_size') is-invalid @enderror" 
                                id="company_size" name="company_size">
                            <option value="">Select Size</option>
                            <option value="1-10" @selected(old('company_size') == '1-10')>1-10 employees</option>
                            <option value="11-50" @selected(old('company_size') == '11-50')>11-50 employees</option>
                            <option value="51-200" @selected(old('company_size') == '51-200')>51-200 employees</option>
                            <option value="201-500" @selected(old('company_size') == '201-500')>201-500 employees</option>
                            <option value="501+" @selected(old('company_size') == '501+')>501+ employees</option>
                        </select>
                        @error('company_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </fieldset>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Register as Employer</button>
                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none">
                    Already have an account? Login here
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('logo').addEventListener('change', function(e) {
        const preview = document.getElementById('logoPreview');
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.style.display = 'block';
            preview.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection