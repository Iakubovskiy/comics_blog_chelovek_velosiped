<?php
namespace App\Repositories;

use App\Models\Tom;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model;

class TomRepository implements RepositoryInterface
{
    function getAll(): Collection
    {
        return Tom::all();
    }
    function getById(int $id): Model|null
    {
        return Tom::find($id);
    }
    function create(array $data): Model
    {
        return Tom::create($data);
    }
    function update(int $id, array $data): Model
    {
        $tom = Tom::find($id);
        $tom->update($data);
        return $tom;
    }
    function delete(int $id): bool
    {
        return Tom::destroy($id);
    }
}