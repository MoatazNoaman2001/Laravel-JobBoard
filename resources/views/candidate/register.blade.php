@extends('layouts.app')

@section('title', 'Employer Registration')

@section('content')
<div class="card rounded-lg shadow">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Employer Registration</h3>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('condidate.store') }}" enctype="multipart/form-data">
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


            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Register as Candidate</button>
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