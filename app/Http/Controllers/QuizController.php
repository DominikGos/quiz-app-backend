<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizStoreRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Http\Resources\QuizResource;
use App\Models\Category;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(): JsonResponse
    {
        $quizzes = Quiz::all();

        return new JsonResponse([
            'quizzes' => QuizResource::collection($quizzes)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $quiz = Quiz::with(['user', 'categories', 'questions'])->findOrFail($id);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ]);
    }

    public function store(QuizStoreRequest $request): JsonResponse
    {
        $quiz = new Quiz($request->validated());
        $quiz->user()->associate(Auth::user());
        $quiz->save();
        $quiz->categories()->attach($request->category_ids);
        $quiz->load(['categories']);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ], 201);
    }

    public function update(QuizUpdateRequest $request, int $id): JsonResponse
    {
        $quiz = Quiz::with(['categories'])->findOrFail($id);
        $quiz->update($request->validated());
        $quiz->save();
        $quiz->categories()->sync($request->category_ids);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ]);
    }
}
