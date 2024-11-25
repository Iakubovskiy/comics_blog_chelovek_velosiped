<?php
namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\OrderRepository;
use Exception;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getAllOrders(): Collection
    {
        return $this->orderRepository->getAll();
    }

    public function getOrderById(int $id): Order|null
    {
        return $this->orderRepository->getById($id);
    }

    public function createOrder(array $data): Order
    {
        if (!isset($data['status'])) 
        {
            $data['status'] = Order::STATUS_CREATED;
        }

        return $this->orderRepository->create($data);
    }

    public function updateOrder(int $id, array $data): Order
    {
        $order = $this->getOrderById($id);

        if (!$order) 
        {
            throw new Exception("Order not found.");
        }

        if ($order->status === Order::STATUS_COMPLETED || $order->status === Order::STATUS_CANCELLED) 
        {
            throw new Exception("Cannot update a completed or cancelled order.");
        }

        return $this->orderRepository->update($id, $data);
    }


    public function deleteOrder(int $id): bool
    {
        $order = $this->getOrderById($id);

        if (!$order) 
        {
            throw new Exception("Order not found.");
        }

        if (in_array($order->status, [Order::STATUS_COMPLETED, Order::STATUS_CANCELLED])) 
        {
            throw new Exception("Cannot delete a completed or cancelled order.");
        }

        return $this->orderRepository->delete($id);
    }


    public function changeOrderStatus(int $id, string $status): Order
    {
        $order = $this->getOrderById($id);

        if (!$order) 
        {
            throw new Exception("Order not found.");
        }

        $validStatuses = Order::getStatuses();

        if (!in_array($status, $validStatuses)) 
        {
            throw new Exception("Invalid status provided.");
        }

        return $this->orderRepository->update($id, ['status' => $status]);
    }


    public function calculateOrderTotal(int $id): float
    {
        $order = $this->getOrderById($id);

        if (!$order) 
        {
            throw new Exception("Order not found.");
        }

        $total = 0;
        foreach ($order->toms as $item) 
        {
            $total += $item->price * $item->pivot->quantity;
        }

        return $total;
    }
}
