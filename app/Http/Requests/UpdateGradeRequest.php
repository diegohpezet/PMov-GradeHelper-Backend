<?php

namespace App\Http\Requests;

use App\Enums\Enums\GradeResult;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGradeRequest extends FormRequest
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
            'comment' => 'nullable|required_without:result|string|max:255',
            'result' => [
                'nullable',
                'required_without:comment',
                Rule::enum(GradeResult::class)
            ],
      ];
    }
}
