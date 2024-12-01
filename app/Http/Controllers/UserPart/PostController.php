<?php

namespace App\Http\Controllers\UserPart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Services\TomService;

class PostController extends Controller
{
    protected $postService;
    protected $tomService;

    public function __construct(PostService $postService, TomService $tomService)
    {
        $this->postService = $postService;
        $this->tomService = $tomService;
    }

    public function index(Request $request, int $tomId)
    {
        $tom = $this->tomService->getTomById($tomId);
        $posts = $tom->post()
            ->when($request->has('search'), function($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->get();
        return view('posts.index', compact('posts', 'tom'));
    }

    public function show(int $id)
    {
        $post = $this->postService->getPostById($id);
        return view('posts.show', compact('post'));
    }
}

