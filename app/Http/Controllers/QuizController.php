<?php

namespace App\Http\Controllers;

use App\Http\HasImage;
use App\Http\Requests\Quiz\QuizStoreRequest;
use App\Http\Requests\Quiz\QuizUpdateRequest;
use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use App\Services\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    use HasImage;

    private const QUIZ_FILES_DIRECTORY = 'quiz';

    public function __construct(private QuizService $quizService)
    {
        $this->configureFileService(self::QUIZ_FILES_DIRECTORY);
    }

    public function index(): JsonResponse
    {
        $quizzes = Quiz::published()->get();

        return new JsonResponse([
            'quizzes' => QuizResource::collection($quizzes)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $quiz = Quiz::published()->with(['user', 'categories', 'questions'])->findOrFail($id);

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

        $this->authorize('update', $quiz);

        $quiz->update($request->validated());
        $quiz->categories()->sync($request->category_ids);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $quiz = Quiz::findOrFail($id);

        $this->authorize('destroy', $quiz);

        $quiz->delete();

        return new JsonResponse(null, 204);
    }

    public function publish(int $id): JsonResponse
    {
        $quiz = $this->quizService->setPublishedStatus($id, true);

        $this->authorize('publish', $quiz);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ]);
    }

    public function unpublish(int $id): JsonResponse
    {
        $quiz = $this->quizService->setPublishedStatus($id, false);

        $this->authorize('unpublish', $quiz);

        return new JsonResponse([
            'quiz' => QuizResource::make($quiz)
        ]);
    }
}
