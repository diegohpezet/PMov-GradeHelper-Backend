<?php

namespace App\Http\Requests;

use App\Enums\GradeableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreGradeableRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'assessment_id' => 'required|exists:assessments,id',
            'gradeable_type' => ['required', new Enum(GradeableType::class)],
            'value' => 'required',
            'comment' => 'nullable|string|max:255',
        ];
    }
}
