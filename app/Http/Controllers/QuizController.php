<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileDestroyRequest;
use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\Quiz\QuizStoreRequest;
use App\Http\Requests\Quiz\QuizUpdateRequest;
use App\Http\Resources\QuizResource;
use App\Models\Category;
use App\Models\Quiz;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    private FileService $fileService;
    private const FILE_DISK = 'public';
    private const QUIZ_FILES_DIRECTORY = 'quiz';

    public function __construct()
    {
        $this->fileService = new FileService(self::QUIZ_FILES_DIRECTORY, self::FILE_DISK);
    }

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

    public function storeImage(FileStoreRequest $request): JsonResponse
    {
        $imageLink = $this->fileService->store($request->file('file'));

        return new JsonResponse([
            'imageLink' => $imageLink,
        ], 201);
    }

    public function destroyImage(FileDestroyRequest $request): JsonResponse
    {
        $this->fileService->destroy($request->file_link);

        return new JsonResponse(null, 204);
    }
}
