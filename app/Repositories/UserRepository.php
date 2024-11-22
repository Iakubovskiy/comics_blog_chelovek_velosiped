<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model;

class UserRepository
{
    function getAll(): Collection
    {
        return User::all();
    }
    function getById(int $id): Model|null
    {
        return User::find($id);
    }
    function create(array $data): Model
    {
        return User::create($data);
    }
    function update(int $id, array $data): Model
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }
    function delete(int $id): bool
    {
        return User::destroy($id);
    }
}