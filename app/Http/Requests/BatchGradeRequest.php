<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchGradeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grades' => [
                'required',
                'array',
            ],
            'grades.*.exercise' => [
                'required',
                'uuid',
            ],
            'grades.*.student' => [
                'required',
                'uuid',
            ],
            'grades.*.comment' => [
                'nullable',
                'string',
            ],
            'grades.*.grade_type' => [
                'string',
            ],
            'grades.*.grade_value' => [
                'string',
            ],
        ];
    }
}
