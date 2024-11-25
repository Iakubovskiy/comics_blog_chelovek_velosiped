<?php
namespace App\Services;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Tom;

class TomService
{
    protected $repository;
    
    public function __construct(RepositoryInterface $repository, protected PhotoService $photoService) {
        $this->repository = $repository;
    }

    public function getAllToms():Collection
    {
        return $this->repository->getAll();
    }

    public function getTomById(int $id):Tom
    {
        return $this->repository->getById($id);
    }

    public function createTom(array $data, array $uploadedFiles = []):Tom
    {
        DB::beginTransaction();
        try {
            $tom = $this->repository->create($data);

            if (!empty($uploadedFiles)) {
                $this->handlePhotoUploads($tom, $uploadedFiles);
            }

            DB::commit();
            return $tom;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create tom: {$e->getMessage()}");
        }
    }

    public function updateTom(int $id, array $data, array $uploadedFiles = []):Tom
    {
        DB::beginTransaction();
        try {
            $tom = $this->getTomById($id);
            
            $updated = $this->repository->update($id, $data);

            if (!$updated) {
                throw new Exception("Failed to update tom");
            }
            
            if (!empty($uploadedFiles)) {
                $this->deleteOldPhotos($tom);
                $this->handlePhotoUploads($tom, $uploadedFiles);
            }

            DB::commit();
            return $this->getTomById($id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to update tom: {$e->getMessage()}");
        }
    }

    protected function handlePhotoUploads(Tom $tom, array $uploadedFiles): void
    {
        $uploadedFiles = array_reverse($uploadedFiles);
        $photoNumber = 1;
        
        foreach ($uploadedFiles as $file) {
            $photo = $this->photoService->createPhoto($file);
            $tom->photos()->attach($photo->id, ['photo_number' => $photoNumber]);
            $photoNumber++;
        }
    }

    public function deleteTom(int $id): bool
    {
        return $this->repository->delete($id);
    }

    protected function deleteOldPhotos(Tom $tom): void
    {
        $images = $tom->photos;
        if(!empty($images))
        {
            foreach ($images as $image) {
                dump($image->id);
                $tom->photos()->detach($image->id);
                $this->photoService->deletePhoto($image->id);
            }
        }
    }
}
