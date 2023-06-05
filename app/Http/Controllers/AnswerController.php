<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerStoreRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $answer = Answer::findOrFail($id);

        return new JsonResponse([
            'answer' => AnswerResource::make($answer)
        ]);
    }

    public function store(AnswerStoreRequest $request): JsonResponse
    {
        //check if user is author of the quiz
        $question = Question::findOrFail($request->question_id);
        $answer = new Answer($request->validated());
        $answer->question()->associate($question);
        $answer->save();

        return new JsonResponse([
            'answer' => AnswerResource::make($answer)
        ]);
    }
}
