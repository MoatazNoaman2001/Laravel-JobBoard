<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'resume' => ['required_without:contact_email', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB
            'contact_email' => ['required_without:resume', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\+\-\(\)]{10,20}$/'],
        ];
    }
}
