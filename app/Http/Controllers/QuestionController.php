<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(): JsonResponse
    {
        $questions = Question::all();

        return new JsonResponse([
            'questions' => QuestionResource::collection($questions)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $question = Question::findOrFail($id);

        return new JsonResponse([
            'question' => QuestionResource::make($question)
        ]);
    }
}
