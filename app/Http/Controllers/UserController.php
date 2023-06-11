<?php

namespace App\Http\Controllers;

use App\Http\HasImage;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use HasImage;

    private const USER_FILES_DIRECTORY = 'user';

    public function __construct()
    {
        $this->configureFileService(self::USER_FILES_DIRECTORY);
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return new JsonResponse([
            'users' => UserResource::collection($users)
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $user = User::with(['quizzes'])->findOrFail($id);

        return new JsonResponse([
            'user' => UserResource::make($user)
        ]);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        $user->update($request->validated());

        return new JsonResponse([
            'user' => UserResource::make($user)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $this->authorize('destroy', $user);

        $user->delete();

        return new JsonResponse(null, 204);
    }
}
