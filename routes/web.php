<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;


Route::get('/', function () {
    return view('welcome');
});

Route::get("/register", [EmployerController::class, 'index']);

Route::post('/register', [EmployerController::class , 'register'])->name('register.employer');

Route::post('/login', [EmployerController::class , 'login'])->name('login');

Route::get('/employer-dash' , [EmployerController::class, 'show'])->name('employer.dashboard');
