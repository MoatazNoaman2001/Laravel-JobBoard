<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidateDashboardController extends Controller
{
    public function index()
    { 
        return view('candidate.dashboard');
    }
}
