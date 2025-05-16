<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;

use App\Http\Controllers\JobController;
use App\Http\Middleware\Employer;
use App\Http\Middleware\Candidate;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

Route::get('/', function () {
    if (auth()->check()){
        $user = auth()->user();
        print('User is logged in');
        if ($user->user_type == 'employer'){
            return redirect()->route('employer.jobs');
        }else if ($user->user_type == 'candidate'){
            return redirect()->route('candidate.jobs.index');
        }if ($user->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }else{
        return redirect()->route('login');
    }
});

Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');


Route::middleware('guest')->group(function () {
    Route::get("employer/register", [EmployerController::class, 'index'])->name('employer.register');
    Route::post('employer/register', [EmployerController::class , 'register'])->name('register.employer');
    Route::view("condidate/register", 'candidate.register')->name('condidate.register');
    Route::post('condidate/register', [CandidateController::class , 'register'])->name('condidate.store');
    Route::view('/login', 'login')->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::view('/forgetpassword', 'auth.forgot-password')->name('auth.forget_password');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [LoginController::class, 'logout'])->name('employer.logout');
});

Route::middleware(['auth', Employer::class])->group(function() {
    Route::view('/job/create', 'employer.createJob')->name('jobs.create');
    Route::post('/job/create', [JobController::class , 'store'])->name('jobs.store');
    Route::get('/employer/jobs', [JobController::class, 'show'])->name('employer.jobs');
    Route::get('/employer/jobs/{id}', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/employer/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/employer/jobs/{id}/edit', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/employer/jobs/{id}/delete', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::view('/employer/{job}/applications', 'jobs.applications')->name('employer.applications');
    Route::delete('/employer/{job}/applications/{application}', [ApplicationController::class, 'destroy'])->name('employer.applications.destroy');
    Route::put('/employer/{job}/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('employer.applications.update');
    Route::put('/employer/{job}/applications/{application}/notes', [ApplicationController::class, 'updateNots'])->name('employer.applications.notes');
    Route::get('/employer-dash' , [EmployerController::class, 'show'])->name('employer.dashboard'); 
});

Route::middleware(['auth', Candidate::class])->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/jobs', [CandidateController::class, 'searchJobs'])->name('candidate.jobs.index');
    Route::get('/jobs/{job}/apply', [ApplicationController::class, 'create'])->name('candidate.jobs.apply');
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('candidate.jobs.apply.store');
    Route::get('/candidate/applications', [CandidateController::class, 'applications'])->name('candidate.applications');
    Route::delete('/candidate/applications/{application}', [CandidateController::class, 'cancelApplication'])->name('candidate.applications.cancel');
    Route::get('/candidate/settings', [CandidateController::class, 'settings'])->name('candidate.settings');
    Route::put('/candidate/settings', [CandidateController::class, 'updateSettings'])->name('candidate.settings.update');
    Route::get('/candidate/dashboard', [CandidateController::class, 'searchJobs'])->middleware(['auth', 'verified', 'candidate']);
});


Route::prefix('conversations')->group(function () {
    Route::get('/', [ConversationController::class, 'index']);
    Route::post('/start', [ConversationController::class, 'start']);
    Route::get('/{id}', [ConversationController::class, 'show']);
    
    // Messages within a conversation
    Route::post('/{conversationId}/messages', [MessageController::class, 'store']);
    Route::post('/{conversationId}/read', [MessageController::class, 'markAsRead']);
})->middleware('auth'); 


// Admin routes
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    // User management
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/details', [App\Http\Controllers\AdminController::class, 'getUserDetails'])->name('users.details');
    Route::post('/users/{id}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');

    // Job management
    Route::get('/jobs', [App\Http\Controllers\AdminController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/{id}/details', [App\Http\Controllers\AdminController::class, 'getJobDetails'])->name('jobs.details');
    Route::post('/job/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveJob'])->name('job.approve');
    Route::post('/job/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectJob'])->name('job.reject');
    Route::delete('/job/{id}', [App\Http\Controllers\AdminController::class, 'deleteJob'])->name('job.delete');

    // Application management
    Route::get('/applications', [App\Http\Controllers\AdminController::class, 'applications'])->name('applications');
    Route::get('/applications/{id}/details', [App\Http\Controllers\AdminController::class, 'getApplicationDetails'])->name('applications.details');
    Route::post('/applications/{id}/update-status', [App\Http\Controllers\AdminController::class, 'updateApplicationStatus'])->name('applications.update-status');
    Route::delete('/applications/{id}', [App\Http\Controllers\AdminController::class, 'deleteApplication'])->name('applications.delete');
});


Route::get('/notifications/job/{notification}', function ($jobId) {
    $user = Auth::user();

    $notification = $user->notifications()
        ->where('data->job_id', $jobId)
        ->first();

    if ($notification && $notification->unread()) {
        $notification->markAsRead();
    }

    $job = Job::findOrFail($jobId);

    return view('candidate.jobs.single', compact('job'));
})->middleware('auth')->name('notifications.viewJob');


Route::get('/admin-test', function () {
    return 'Admin middleware is working correctly!';
})->middleware(['auth', IsAdmin::class])->name('admin.test');

require __DIR__.'/auth.php';