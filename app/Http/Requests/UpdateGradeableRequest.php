<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'value' => 'required',
            'comment' => 'nullable|string|max:255'
        ];

        switch ($this->route('gradeable')->gradable_type) {
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
