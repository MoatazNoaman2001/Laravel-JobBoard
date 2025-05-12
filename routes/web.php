<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;

use App\Http\Controllers\JobController;

use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return view('welcome');
});

// Route::post('/login', [EmployerController::class , 'login'])->name('login');


Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('guest')->group(function () {
    Route::get("employer/register", [EmployerController::class, 'index']);
    Route::post('employer/register', [EmployerController::class , 'register'])->name('register.employer');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


Route::middleware(['auth', 'employer'])->group(function() {
    Route::view('/job/create', 'employer.createJob')->name('job.create');
    Route::post('/job/create', [JobController::class , 'store'])->name('jobs.store');
    Route::get('/employer/jobs', [JobController::class, 'show'])->name('employer.jobs');
    Route::get('/employer-dash' , [EmployerController::class, 'show'])->name('employer.dashboard');
});