<?php
namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model;

class RoleRepository
{
    function getAll(): Collection
    {
        return Role::all();
    }
    function getById(int $id): Model|null
    {
        return Role::find($id);
    }
    function create(array $data): Model
    {
        return Role::create($data);
    }
    function update(int $id, array $data): Model
    {
        $role = Role::find($id);
        $role->update($data);
        return $role;
    }
    function delete(int $id): bool
    {
        return Role::destroy($id);
    }
}