<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(): JsonResponse
    {
        $answers = Answer::all();

        return new JsonResponse([
            'answers' => AnswerResource::collection($answers)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $answer = Answer::findOrFail($id);

        return new JsonResponse([
            'answer' => AnswerResource::make($answer)
        ]);
    }
}
