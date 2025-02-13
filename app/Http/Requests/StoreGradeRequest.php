<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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
        $rules = [
            'student_id' => 'required|exists:students,id',
            'assessment_id' => 'required|exists:assessments,id',
            'gradeable_type' => 'required|in:PassFailGrade,TEGrade,NumericGrade',
            'value' => 'required',
            'comment' => 'nullable|string|max:255',
        ];

        switch ($this->input('gradeable_type')) {
            case 'PassFailGrade':
                $rules['value'] = 'required|boolean';
                break;

            case 'TEGrade':
                $rules['value'] = 'required|in:TEA,TEP,TED';
                break;

            case 'NumericGrade':
                $rules['value'] = 'required|numeric|min:0|max:10';
                break;
        }

        return $rules;
    }
}
