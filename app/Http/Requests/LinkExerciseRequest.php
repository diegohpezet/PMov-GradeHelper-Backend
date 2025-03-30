<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'exercise' => 'required|exists:exercises,id',
            'due_at' => 'required|date|after:today',
        ];
    }
}
