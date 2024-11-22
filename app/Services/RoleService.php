<?php
namespace App\Services;

use App\Models\Role;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    protected $repository;
    
    public function __construct(RepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getAllRoles():Collection
    {
        return $this->repository->getAll();
    }

    public function getRoleById(int $id):Role
    {
        return $this->repository->getById($id);
    }

    public function createRole(array $data):Role
    {
        return $this->repository->create($data);
    }

    public function updateRole(int $id, array $data):Role
    {
        return $this->repository->update($id, $data);
    }

    public function deleteRole(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
