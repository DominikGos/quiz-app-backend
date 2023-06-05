<?php

namespace App\Http\Requests\Quiz;

trait QuizValidation
{
    public function quizValidationRules(): array
    {
        return [
            'description' => 'string|min:3',
            'image' => 'string|max:255|nullable',
            'category_ids' => 'array|nullable',
            'category_ids.*' => 'integer|min:1'
        ];
    }
}
