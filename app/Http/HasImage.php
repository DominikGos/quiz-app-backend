<?php

namespace App\Http;

use App\Http\Requests\File\FileDestroyRequest;
use App\Http\Requests\File\FileStoreRequest;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;

trait HasImage
{
    private FileService $fileService;

    public function configureFileService(string $directory, string $disk = 'public'): void
    {
        $this->fileService = new FileService($directory, $disk);
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
