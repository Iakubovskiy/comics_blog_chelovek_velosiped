<?php
namespace App\Services;

use App\Repositories\RepositoryInterface;
use App\Services\Interfaces\FileUploadServiceInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

class PhotoService
{
    public function __construct(
        protected RepositoryInterface $repository,
        protected FileUploadServiceInterface $fileUploader
    ) {}

    public function createPhoto(UploadedFile $file): Model
    {
        try {
            $url = $this->fileUploader->uploadFile($file);
            
            return $this->repository->create([
                'url' => $url
            ]);
        } catch (Exception $e) {
            throw new Exception("Failed to upload photo: {$e->getMessage()}");
        }
    }

    public function deletePhoto(int $id): bool
    {
        dump($id);
        $photo = $this->repository->getById($id);
        if (!$photo) {
            throw new Exception("Photo with ID {$id} not found");
        }

        try {
            $this->fileUploader->deleteFile($photo->url);
            return $this->repository->delete($id);
        } catch (Exception $e) {
            throw new Exception("Failed to delete photo: {$e->getMessage()}");
        }
    }

    public function deletePhotos(array $photos): void
    {
        foreach ($photos as $photo) {
            try {
                $this->deletePhoto($photo->id);
            } catch (Exception $e) {
                Log::error("Failed to delete photo {$photo->id}: {$e->getMessage()}");
            }
        }
    }
}
