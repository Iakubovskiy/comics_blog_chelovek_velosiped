<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Services\PostService;
use App\DTO\PostDTO;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function getAllPosts()
    {
        try {
            $posts = $this->postService->getAllPosts();
            return $this->sendResponse($posts, 'Posts retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve posts', ['error' => $e->getMessage()]);
        }
    }

    public function getPostById(int $id)
    {
        try {
            $post = $this->postService->getPostById($id);
            return $this->sendResponse($post, 'Post retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve post', ['error' => $e->getMessage()]);
        }
    }

    public function createPost(Request $request)
    {
        try {
            $postDTO = new PostDTO(
                userId: $request->input('user_id'),
                title: $request->input('title'),
                description: $request->input('description'),
                tomId: $request->input('tom_id')
            );

            $uploadedFiles = $request->file('images', []);

            $post = $this->postService->createPost($postDTO, $uploadedFiles);
            return $this->sendResponse($post, 'Post created successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create post', ['error' => $e->getMessage()]);
        }
    }

    public function updatePost(Request $request, int $id)
    {
        try {
            $postDTO = new PostDTO(
                userId: $request->input('user_id'),
                title: $request->input('title'),
                description: $request->input('description'),
                tomId: $request->input('tom_id')
            );

            $uploadedFiles = $request->file('images', []);

            $post = $this->postService->updatePost($id, $postDTO, $uploadedFiles);
            return $this->sendResponse($post, 'Post updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update post', ['error' => $e->getMessage()]);
        }
    }

    public function deletePost(int $id)
    {
        try {
            $this->postService->deletePost($id);
            return $this->sendResponse(null, 'Post deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete post', ['error' => $e->getMessage()]);
        }
    }
}
