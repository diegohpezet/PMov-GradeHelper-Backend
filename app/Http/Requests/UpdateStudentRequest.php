<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
          'first_name' => 'nullable|string|max:255',
          'last_name' => 'nullable|string|max:255',
          'githubUsername' => [
            'nullable',
            'string',
            Rule::unique('students')->ignore(request()->route('student')),
        ],
          'user_id' => 'nullable|exists:users,id',
          'course_id' => 'nullable|exists:courses,id',
      ];
    }
}
