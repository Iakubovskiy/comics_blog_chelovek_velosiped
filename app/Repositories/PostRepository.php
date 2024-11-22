<?php
namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model;

class PostRepository
{
    function getAll(): Collection
    {
        return Post::all();
    }
    function getById(int $id): Model|null
    {
        return Post::find($id);
    }
    function create(array $data): Model
    {
        return Post::create($data);
    }
    function update(int $id, array $data): Model
    {
        $post = Post::find($id);
        $post->update($data);
        return $post;
    }
    function delete(int $id): bool
    {
        return Post::destroy($id);
    }
}