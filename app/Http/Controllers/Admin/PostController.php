<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTO\PostDTO;
use App\Services\PostService;

class PostController extends Controller
{
    private PostService $postService;
    public function __construct(PostService $postService) {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tom_id' => 'required|exists:toms,id',
        ]);
        $postDTO = new PostDTO(...$data);
        $uploadedFiles = $request->file('images', []);
        $this->postService->createPost($postDTO, $uploadedFiles);
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(int $id)
    {
        $post = $this->postService->getPostById($id);
        $images = $post->images;
        return view('admin.posts.edit', compact('post','images'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tom_id' => 'required|exists:toms,id',
        ]);
        $postDTO = new PostDTO(...$data);
        $uploadedFiles = $request->file('images', []);
        $this->postService->updatePost($id, $postDTO, $uploadedFiles);
        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(int $id)
    {
        $this->postService->deletePost($id);
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
