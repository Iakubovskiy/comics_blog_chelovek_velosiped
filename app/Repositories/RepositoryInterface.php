<?php
namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection;
    public function getById(int $id): ?\Illuminate\Database\Eloquent\Model;
    public function create(array $data): \Illuminate\Database\Eloquent\Model;
    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model;
    public function delete(int $id): bool;
}