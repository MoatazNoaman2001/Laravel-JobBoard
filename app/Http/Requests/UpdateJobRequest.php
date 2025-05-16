<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'responsibilities' => 'required|string',
            'skills' => 'required|array',
            'qualifications' => 'required|array',
            'salary_range.min' => 'required|numeric',
            'salary_range.max' => 'required|numeric|gt:salary_range.min',
            'exp_range.min' => 'required|numeric',
            'exp_range.max' => 'required|numeric|gt:exp_range.min',
            'benefits' => 'nullable|array',
            'location.address' => 'required|string',
            'location.city' => 'required|string',
            'location.state' => 'required|string',
            'location.country' => 'required|string',
            'location.postal_code' => 'required|string',
            'work_type' => 'required|in:remote,on_site,hybrid',
            'application_deadline' => 'required|date|after:today',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
