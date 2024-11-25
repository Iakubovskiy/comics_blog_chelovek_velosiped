<?php
namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Model;

class OrderRepository implements RepositoryInterface
{
    function getAll(): Collection
    {
        return Order::all();
    }
    function getById(int $id): Model|null
    {
        return Order::find($id);
    }
    function create(array $data): Model
    {
        return Order::create($data);
    }
    function update(int $id, array $data): Model
    {
        $role = Order::find($id);
        $role->update($data);
        return $role;
    }
    function delete(int $id): bool
    {
        return Order::destroy($id);
    }
}