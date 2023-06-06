<?php

namespace App\Http\Requests\Question;

trait QuestionValidation
{
    public function questionValidationRules(): array
    {
        return [
            'content' => 'required|string|min:3',
            'image' => 'nullable|string|max:255',
            'quiz_id' => 'required|integer'
        ];
    }
}
