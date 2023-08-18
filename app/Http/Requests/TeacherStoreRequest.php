<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'unique:teachers,email', 'email'],
            'name' => ['required', 'max:255', 'string'],
            'gender' => ['required', 'in:laki-laki,perempuan,lainnya'],
            'password' => ['required'],
        ];
    }
}
