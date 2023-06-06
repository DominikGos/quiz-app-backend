<?php

namespace App\Http\Requests\Answer;

trait AnswerValidation
{
    public function answerValidationRules(): array
    {
        return [
            'question_id' => 'required|integer',
            'content' => 'nullable|string|min:1|max:255',
            'image' => 'nullable|string|max:255',
            'is_correct' => 'nullable|boolean',
        ];
    }
}
