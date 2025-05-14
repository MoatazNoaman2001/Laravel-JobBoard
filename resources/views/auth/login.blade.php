
@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="title-text">
        <div class="title login">Login Form</div>
    </div>
    <div class="form-container">
        <div class="form-inner">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" value="Login">
                </div>
                <div class="signup-link">
                    Not a member? <a href="{{ route('register') }}">Signup now</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection