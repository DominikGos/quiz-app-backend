<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileDestroyRequest;
use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private FileService $fileService;
    private const FILE_DISK = 'public';
    private const USER_FILES_DIRECTORY = 'user';

    public function __construct()
    {
        $this->fileService = new FileService(self::USER_FILES_DIRECTORY, self::FILE_DISK);
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
        $user = User::findOrFail($id);

        return new JsonResponse([
            'user' => UserResource::make($user)
        ]);
    }

    public function update(UserUpdateRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());

        return new JsonResponse([
            'user' => UserResource::make($user)
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return new JsonResponse(null, 204);
    }

    public function storeAvatar(FileStoreRequest $request): JsonResponse
    {
        $imagePath = $this->fileService->store($request->file('file'));

        return new JsonResponse([
            'avatarPath' => $imagePath,
        ], 201);
    }

    public function destroyAvatar(FileDestroyRequest $request): JsonResponse
    {
        $this->fileService->destroy($request->file_path);

        return new JsonResponse(null, 204);
    }
}
