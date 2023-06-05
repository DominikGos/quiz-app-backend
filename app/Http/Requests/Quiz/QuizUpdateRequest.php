<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'string', 'min:3', 'max:255', 'required', Rule::unique('quizzes', 'name')->ignore($this->route('id'))
            ],
            'description' => 'string|min:3|nullable',
            'image' => 'string|max:255|nullable',
            'category_ids' => 'array|nullable',
            'category_ids.*' => 'integer|min:1'
        ];
    }
}
