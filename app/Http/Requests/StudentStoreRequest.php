<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'nis' => ['required', 'max:9', 'string'],
            'gender' => ['required', 'in:laki-laki,perempuan,lainnya'],
            'password' => ['required'],
            'class_student_id' => ['required', 'exists:class_students,id'],
        ];
    }
}
