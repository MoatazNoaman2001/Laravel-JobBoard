<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;

use App\Http\Controllers\JobController;
use App\Http\Middleware\Employer;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    if (auth()->user()){
        $user = auth()->user();
        if ($user->user_type === 'employer'){
            return view('employer.jobs', ['jobs'=> $user->jobs()->get()]);
        }else{

        }
    }
    return view('welcome');
});

Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware('guest')->group(function () {
    Route::get("employer/register", [EmployerController::class, 'index'])->name('employer.register');
    Route::post('employer/register', [EmployerController::class , 'register'])->name('register.employer');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


Route::middleware(['auth', Employer::class])->group(function() {
    Route::view('/job/create', 'employer.createJob')->name('jobs.create');
    Route::post('/job/create', [JobController::class , 'store'])->name('jobs.store');
    Route::get('/employer/jobs', [JobController::class, 'show'])->name('employer.jobs');
    Route::get('/employer/jobs/{id}', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/employer/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::delete('/employer/jobs/{id}/delete', [JobController::class, 'delete'])->name('jobs.destroy');
    Route::get('/employer-dash' , [EmployerController::class, 'show'])->name('employer.dashboard'); 
    Route::post('/logout', [LoginController::class, 'logout'])->name('employer.logout');
});