<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;

use App\Http\Controllers\JobController;
use App\Http\Middleware\Employer;
use App\Http\Middleware\Condidate;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateController;


Route::get('/', function () {
    if (auth()->check()){
        $user = auth()->user();
        print('User is logged in');
        if ($user->user_type == 'employer'){
            return redirect()->route('employer.jobs');
        }else if ($user->user_type == 'candidate'){
            return redirect()->route('candidate.jobs.index');
        }
    }else{
        return view('login');
    }
});

Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('guest')->group(function () {
    Route::get("employer/register", [EmployerController::class, 'index'])->name('employer.register');
    Route::post('employer/register', [EmployerController::class , 'register'])->name('register.employer');
    Route::view("condidate/register", 'candidate.register')->name('condidate.register');
    Route::post('condidate/register', [CandidateController::class , 'register'])->name('condidate.store');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::get('/logout', [LoginController::class, 'logout'])->name('employer.logout')->middleware('auth');

Route::middleware(['auth', Employer::class])->group(function() {
    Route::view('/job/create', 'employer.createJob')->name('jobs.create');
    Route::post('/job/create', [JobController::class , 'store'])->name('jobs.store');
    Route::get('/employer/jobs', [JobController::class, 'show'])->name('employer.jobs');
    Route::get('/employer/jobs/{id}', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/employer/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/employer/jobs/{id}/edit', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/employer/jobs/{id}/delete', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/employer-dash' , [EmployerController::class, 'show'])->name('employer.dashboard'); 
});

Route::middleware(['auth', Condidate::class])->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/jobs', [CandidateController::class, 'searchJobs'])->name('candidate.jobs.index');
    Route::get('/jobs/{job}/apply', [CandidateController::class, 'showApplyForm'])->name('candidate.jobs.apply');
    Route::post('/jobs/{job}/apply', [CandidateController::class, 'applyJob'])->name('candidate.jobs.apply.store');
    Route::get('/candidate/applications', [CandidateController::class, 'applications'])->name('candidate.applications');
    Route::delete('/candidate/applications/{application}', [CandidateController::class, 'cancelApplication'])->name('candidate.applications.cancel');
    Route::get('/candidate/settings', [CandidateController::class, 'settings'])->name('candidate.settings');
    Route::put('/candidate/settings', [CandidateController::class, 'updateSettings'])->name('candidate.settings.update');
    Route::get('/candidate/dashboard', [CandidateController::class, 'searchJobs'])->middleware(['auth', 'verified', 'candidate']);
});