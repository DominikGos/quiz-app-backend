<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizUpdateRequest extends FormRequest
{
    use QuizValidation;
    
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'string', 'min:3', 'max:255', 'required', Rule::unique('quizzes', 'name')->ignore($this->route('id'))
            ],
        ];

        return [
            ...$rules,
            ...$this->quizValidationRules()
        ];
    }
}
