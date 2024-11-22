<?php
namespace App\Repositories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model;

class PhotoRepository implements RepositoryInterface{
    function getAll(): Collection
    {
        return Photo::all();
    }
    function getById(int $id): Model|null
    {
        return Photo::find($id);
    }
    function create(array $data): Model{
        return Photo::create($data);
    }
    function update(int $id, array $data): Model{
        $photo = Photo::find($id);
        $photo->update($data);
        return $photo;
    }
    function delete(int $id): bool{
        return Photo::destroy($id);
    }
}