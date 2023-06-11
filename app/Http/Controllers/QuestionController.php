<?php

namespace App\Http\Controllers;

use App\Http\HasImage;
use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    use HasImage;

    private const QUESTION_FILES_DIRECTORY = 'question';

    public function __construct()
    {
        $this->configureFileService(self::QUESTION_FILES_DIRECTORY);
    }

    public function show(int $id): JsonResponse
    {
        $question = Question::with(['answers'])->findOrFail($id);

        return new JsonResponse([
            'question' => QuestionResource::make($question)
        ]);
    }

    public function store(QuestionStoreRequest $request): JsonResponse
    {
        $quiz = Quiz::findOrFail($request->quiz_id);
        $question = new Question($request->validated());
        $question->quiz()->associate($quiz);

        $this->authorize('store', $question);

        $question->save();

        return new JsonResponse([
            'question' => QuestionResource::make($question)
        ], 201);
    }

    public function update(QuestionUpdateRequest $request, int $id): JsonResponse
    {
        $question = Question::findOrFail($id);

        $this->authorize('update', $question);

        $question->update($request->validated());

        return new JsonResponse([
            'question' => QuestionResource::make($question)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $question = Question::findOrFail($id);

        $this->authorize('destroy', $question);

        $question->delete();

        return new JsonResponse(null, 204);
    }
}
