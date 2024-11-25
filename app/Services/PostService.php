<?php
namespace App\Services;

use App\DTO\PostDTO;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\Log;

class PostService
{
    public function __construct(
        protected RepositoryInterface $repository,
        protected PhotoService $photoService
    ) {}

    public function getAllPosts():Collection
    {
        return $this->repository->getAll();
    }

    public function getPostById(int $id):Model
    {
        return $this->repository->getById($id);
    }

    public function updatePost(int $id, PostDTO $postData, array $uploadedFiles = []): Model
    {
        DB::beginTransaction();
        try {
            $post = $this->getPostById($id);
            
            $updated = $this->repository->update($id, [
                'title' => $postData->title,
                'Description' => $postData->description,
                'tom_id' => $postData->tom_id,
            ]);

            if (!$updated) {
                throw new Exception("Failed to update post");
            }
           
            if (!empty($uploadedFiles)) {
                $this->deleteOldPhotos($post);
                $this->handlePhotoUploads($post, $uploadedFiles);
            }

            DB::commit();
            return $this->getPostById($id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to update post: {$e->getMessage()}");
        }
    }

    public function createPost(PostDTO $postData, array $uploadedFiles = []): Model
    {
        DB::beginTransaction();
        try {
            $post = $this->repository->create([
                'title' => $postData->title,
                'Description' => $postData->description,
                'tom_id' => $postData->tom_id,
            ]);
           
            if (!empty($uploadedFiles)) 
            {
                $this->handlePhotoUploads($post, $uploadedFiles);
            }

            DB::commit();
            return $post;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Failed to create post: {$e->getMessage()}");
        }
    }

    protected function handlePhotoUploads(Post $post, array $uploadedFiles): void
    {
        $uploadedFiles = array_reverse($uploadedFiles);
        $photoNumber = 1;
        
        foreach ($uploadedFiles as $file) {
            $photo = $this->photoService->createPhoto($file);
            $post->images()->attach($photo->id, ['photo_number' => $photoNumber]);
            $photoNumber++;
        }
    }

    public function deletePost(int $id):bool
    {
        return $this->repository->delete($id);
    }

    protected function deleteOldPhotos(Post $post): void
    {
        $images = $post->images;
        Log::info('Hello!!! '.$images->count());
        foreach ($images as $image) {
            dump($image->id);
            $post->images()->detach($image->id);
            $this->photoService->deletePhoto($image->id);
        }
    }
}
