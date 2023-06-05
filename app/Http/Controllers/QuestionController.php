<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $question = Question::with(['answers'])->findOrFail($id);

        return new JsonResponse([
            'question' => QuestionResource::make($question)
        ]);
    }

    public function store(QuestionStoreRequest $request): JsonResponse
    {
        //check if user is author of the quiz!
        $quiz = Quiz::findOrFail($request->quiz_id);
        $question = new Question($request->validated());
        $question->quiz()->associate($quiz);
        $question->save();

        return new JsonResponse([
            'question' => QuestionResource::make($question)
        ], 201);
    }
}
