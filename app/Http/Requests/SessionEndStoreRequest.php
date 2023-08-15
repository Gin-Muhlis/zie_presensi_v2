<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionEndStoreRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'class_student_id' => ['required', 'exists:class_students,id'],
        ];
    }
}
