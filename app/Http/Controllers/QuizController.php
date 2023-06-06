<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\QuizStoreRequest;
use App\Http\Requests\Quiz\QuizUpdateRequest;
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
        // dd($request->all(), $request->validated());
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
        $quiz->categories()->sync($request->category_ids);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return new JsonResponse(null, 204);
    }
}
