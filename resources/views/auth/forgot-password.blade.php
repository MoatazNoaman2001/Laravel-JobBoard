@extends('layouts.app')

@section('content')

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">{{ __('Reset Password') }}</h4>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        {{ __('Forgot your password? No problem. Just enter your email address and we\'ll email you a password reset link.') }}
                    </p>
                </div>
                
                <form method="POST" action="{{ route('password.email') }}" class="mx-4">
                    @csrf
                    <div class="mb-3 ">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-paper-plane me-2"></i>{{ __('Send Reset Link') }}
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <a class="text-decoration-none" href="{{ route('login') }}">
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


