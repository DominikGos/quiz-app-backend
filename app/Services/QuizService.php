<?php

namespace App\Services;

use App\Models\Quiz;

class QuizService
{
    public function setPublishedStatus(int $quizId, bool $status): Quiz
    {
        $quiz = Quiz::with(['user', 'categories', 'questions'])->findOrFail($quizId);
        $quiz->is_published = $status;
        $quiz->save();

        return $quiz;
    }
}
