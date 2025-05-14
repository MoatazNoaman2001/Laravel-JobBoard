@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full flex bg-gradient-to-b from-gray-50 to-blue-100 p-8 gap-6">
    
    <!-- Sidebar Filters (flush to the left in LTR) -->
     
    <div class="w-1/4 bg-white p-6 rounded-lg shadow-md h-full sticky top-0 ml-[-2rem]">
        <br><br>
        <h3 class="text-2xl font-bold mb-4">Job Filters</h3>
        <form method="GET" action="{{ route('candidate.jobs.index') }}">
            <input type="text" name="keywords" placeholder="Keywords or Skills" class="mb-4 w-full p-2 border rounded" value="{{ request('keywords') }}">

            <!-- <input type="text" name="location" placeholder="Location" class="mb-4 w-full p-2 border rounded" value="{{ request('location') }}"> -->

            <select name="category" class="mb-4 w-full p-2 border rounded">
                <option value="">Select Category</option>
                <option value="IT" {{ request('category') == 'IT' ? 'selected' : '' }}>Information Technology</option>
                <option value="Marketing" {{ request('category') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                <option value="Finance" {{ request('category') == 'Finance' ? 'selected' : '' }}>Finance</option>
            </select>

            <select name="experience_level" class="mb-4 w-full p-2 border rounded">
                <option value="">Select Experience Level</option>
                <option value="Entry" {{ request('experience_level') == 'Entry' ? 'selected' : '' }}>Entry</option>
                <option value="Mid" {{ request('experience_level') == 'Mid' ? 'selected' : '' }}>Mid</option>
                <option value="Senior" {{ request('experience_level') == 'Senior' ? 'selected' : '' }}>Senior</option>
            </select>

            <select name="work_type" class="mb-4 w-full p-2 border rounded">
                <option value="">Select Work Type</option>
                <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="on-site" {{ request('work_type') == 'on-site' ? 'selected' : '' }}>On-site</option>
            </select>

            <input type="number" name="expected_salary" placeholder="Expected Salary ($)" class="mb-4 w-full p-2 border rounded" value="{{ request('expected_salary') }}">

            <select name="country" class="mb-4 w-full p-2 border rounded" id="countries-select">
                <option value="">Select Country</option>
                <!-- Populated by API -->
            </select>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Search</button>
        </form>
    </div>

    <!-- Job Listings -->
    <div class="w-3/4">
        @if ($jobs->isEmpty())
            <p class="text-gray-700">No jobs match your search criteria.</p>
        @else
            @foreach ($jobs as $job)
                <div class="bg-white p-6 rounded shadow mb-6">
                    <h2 class="text-xl font-bold">{{ $job->title }}</h2>
                    <p><strong>Company:</strong> {{ $job->company ?? 'Not specified' }}</p>
                    <p><strong>Location:</strong> {{ $job->location ?? 'Not specified' }}</p>
                    <p><strong>Country:</strong> {{ $job->country ?? 'Not specified' }}</p>
                    <p><strong>Salary:</strong> ${{ number_format($job->salary, 2) ?? 'Not specified' }}</p>
                    <p><strong>Category:</strong> {{ $job->category ?? 'Not specified' }}</p>
                    <p><strong>Experience Level:</strong> {{ $job->experience_level ?? 'Not specified' }}</p>
                    <p><strong>Work Type:</strong> {{ $job->work_type ?? 'Not specified' }}</p>
                    <p><strong>Deadline:</strong> {{ $job->deadline ? $job->deadline->format('d/m/Y') : 'Not specified' }}</p>
                    <p>{{ Str::limit($job->description ?? '', 200) }}</p>
                    <a href="{{ route('candidate.jobs.apply', $job->id) }}" class="inline-block bg-green-500 text-white py-2 px-4 mt-2 rounded hover:bg-green-600">Apply Now</a>
                </div>
            @endforeach

            {{ $jobs->links() }}
        @endif
    </div>
</div>

<script>
    // Fetch country list from an external API
    fetch("https://restcountries.com/v3.1/all")
        .then(res => res.json())
        .then(data => {
            let countrySelect = document.getElementById("countries-select");
            data.sort((a, b) => a.name.common.localeCompare(b.name.common));
            data.forEach(country => {
                let option = document.createElement("option");
                option.value = country.name.common;
                option.text = country.name.common;
                countrySelect.appendChild(option);
            });
        })
        .catch(err => console.error("Error loading countries:", err));
</script>
@endsection