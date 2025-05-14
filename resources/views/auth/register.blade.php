

  @extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="title-text">
        <div class="title signup">Signup Form</div>
    </div>
    <div class="form-container">
        <div class="form-inner">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field">
                    <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <select name="user_type" id="user_type" required>
                        <option value="" selected>Select Account Type</option>
                        <option value="candidate" {{ old('user_type') == 'candidate' ? 'selected' : '' }}>Candidate</option>
                        <option value="employer" {{ old('user_type') == 'employer' ? 'selected' : '' }}>Employer</option>
                    </select>
                    @error('user_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="field">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" value="Signup">
                </div>
                <div class="signup-link">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('user_type').addEventListener('change', function() {
    const defaultOption = this.querySelector('option[value=""]');
    if (this.value !== '') {
        defaultOption.remove();
    }
});
</script>
@endsection