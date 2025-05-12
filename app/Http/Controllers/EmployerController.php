<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Models\Employer;
use Illuminate\View\View;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployerRegistrationRequest;
use App\Http\Requests\EmployerProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
 

class EmployerController extends Controller
{
    public function register(EmployerRegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'employer',
        ]);

        $employer = Employer::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'description' => $request->description,
            'website' => $request->website,
            'industry' => $request->industry,
            'company_size' => $request->company_size,
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $employer->update(['logo' => $path]);
        }

        Auth::login($user);

        return to_route('employer.dashboard')->with('success', 'Registration successful!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employer.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employer $employer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employer $employer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployerRequest $request, Employer $employer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        //
    }
}
