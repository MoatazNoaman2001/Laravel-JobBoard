@extends('layouts.app')

@section('header')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply for :job_title', ['job_title' => $job->title]) }}
        </h2>
    </x-slot>
    @endsection
    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('candidate.jobs.apply.store', $job->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <x-input-label for="cover_letter" :value="__('Cover Letter (Optional)')" />
                            <textarea id="cover_letter" name="cover_letter" class="form-control" rows="5">{{ old('cover_letter') }}</textarea>
                            <x-input-error :messages="$errors->get('cover_letter')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <x-input-label for="contact_email" :value="__('Email Address')" />
                            <x-text-input id="contact_email" name="contact_email" value="{{ old('contact_email', auth()->user()->email) }}" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <x-input-label for="contact_phone" :value="__('Phone Number (Optional)')" />
                            <x-text-input id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <x-input-label for="resume" :value="__('Upload Resume')" />
                            <input id="resume" type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                            <x-input-error :messages="$errors->get('resume')" class="mt-2" />
                        </div>
                        <x-primary-button>
                            {{ __('Submit Application') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection