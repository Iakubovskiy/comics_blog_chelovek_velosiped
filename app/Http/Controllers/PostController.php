<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tom;
use App\Models\Chapter;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::when($query, function ($q) use ($query) {
            return $q->where('title', 'like', "%{$query}%");
        })
            ->with(['tom', 'chapter'])
            ->paginate(10);

        return view('admin.posts.index', compact('posts', 'query'));
    }



    public function create()
    {
        $toms = Tom::all();
        $chapters = Chapter::all();
        return view('admin.posts.create', compact('toms', 'chapters'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'Description' => 'nullable|string',
            'tom_id' => 'required|exists:toms,id',
            'chapter_id' => 'required|exists:chapters,id',
        ]);
        $validatedData['user_id'] = 24;
        Post::create($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Пост успішно створено');
    }

    public function edit(Post $post)
    {
        $toms = Tom::all();
        $chapters = Chapter::all();
        return view('admin.posts.edit', compact('post', 'toms', 'chapters'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'Description' => 'nullable|string',
            'tom_id' => 'required|exists:toms,id',
            'chapter_id' => 'required|exists:chapters,id',
        ]);
        $validatedData['user_id'] = 24;
        $post->update($validatedData);

        return redirect()->route('admin.posts.index')->with('success', 'Пост успішно оновлено');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Пост успішно видалено');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::when($query, function ($q) use ($query) {
            return $q->where('title', 'like', "%{$query}%");
        })->with(['tom', 'chapter'])->get();

        return response()->json(['posts' => $posts]);
    }

    public function filter(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::when($query, function ($q) use ($query) {
            return $q->where('title', 'like', "%{$query}%");
        })->with(['tom', 'chapter'])->get();

        return response()->json(['posts' => $posts]);
    }
}
