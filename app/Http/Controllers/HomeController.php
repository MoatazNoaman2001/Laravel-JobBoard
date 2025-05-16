<?php

namespace App\Http\Controllers;

use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $latestJobs = Job::orderBy('created_at', 'desc')->take(6)->get();

        return view('home', compact('latestJobs'));
    }
}
