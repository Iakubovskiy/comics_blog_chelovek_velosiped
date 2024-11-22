<?php
namespace App\Services;

use App\DTO\PostDTO;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Exception;

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
                'user_id' => $postData->userId,
                'title' => $postData->title,
                'description' => $postData->description,
                'tom_id' => $postData->tomId,
            ]);

            if (!$updated) {
                throw new Exception("Failed to update post");
            }

            if (!empty($uploadedFiles)) {
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
                'user_id' => $postData->userId,
                'title' => $postData->title,
                'description' => $postData->description,
                'tom_id' => $postData->tomId,
            ]);

            if (!empty($uploadedFiles)) {
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
        $photoNumber = $post->images()->max('photo_number') ?? 0;
        
        foreach ($uploadedFiles as $file) {
            $photoNumber++;
            $photo = $this->photoService->createPhoto($file);
            $post->images()->attach($photo->id, ['photo_number' => $photoNumber]);
        }
    }

    public function deletePost(int $id):bool
    {
        return $this->repository->delete($id);
    }
}
