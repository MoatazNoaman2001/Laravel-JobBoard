@extends('layouts.app')

@section('content')

<p style="color:red;">Testing update - version 1</p>
<div style="min-height: 100vh; background-color: #f0f4f8; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="width: 350px; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="font-size: 18px; font-weight: 600; color: #333; margin-bottom: 20px; text-align: center;">Account Settings</h2>
        <form method="POST" action="{{ route('candidate.settings.update') }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="name" style="font-size: 14px; font-weight: 500; color: #555;">Name</label>
                <input id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
                @error('name')
                    <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 15px;">
                <label for="email" style="font-size: 14px; font-weight: 500; color: #555;">Email Address</label>
                <input id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    style="width: 100%; padding: 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;">
                @error('email')
                    <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" style="width: 100%; background-color: #2563eb; color: white; padding: 10px; font-size: 15px; font-weight: 600; border-radius: 6px; border: none; cursor: pointer;">
                Update Settings
            </button>
        </form>
    </div>
</div>
@endsection
