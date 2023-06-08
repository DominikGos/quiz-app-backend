<?php

namespace Tests\Unit;

use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileServiceTest extends TestCase
{
    private FileService $fileService;
    private const TEST_DIRECTORY = 'testDirectory';
    private const TEST_DISK = 'testDisk';

    public function setUp(): void
    {
        parent::setUp();
        $this->fileService = new FileService(self::TEST_DIRECTORY, self::TEST_DISK);
    }

    public function test_store_method_returns_link_to_a_file(): void
    {
        $imageName = $this->storeFile();

        Storage::disk(self::TEST_DISK)->assertExists($imageName);
    }

    public function test_destroy_method_removes_a_image_from_storage(): void
    {
        $imageName = $this->storeFile();

        $this->fileService->destroy($imageName);

        Storage::disk(self::TEST_DISK)->assertMissing($imageName);
    }

    private function storeFile(): string
    {
        $imageName = 'photo.jpg';
        Storage::fake(self::TEST_DISK);
        $image = UploadedFile::fake()->image($imageName);
        $imageLink = $this->fileService->store($image);
        $imageName = $this->fileService->getFilePath($imageLink);

        return $imageName;
    }
}
