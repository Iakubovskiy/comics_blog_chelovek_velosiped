<?php
namespace App\Http\Controllers\Api;

use App\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Exception;

class OrderController extends BaseController
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getAllOrders()
    {
        $orders = $this->orderService->getAllOrders();
        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }

    public function getOrderById($id)
    {
        try {
            $order = $this->orderService->getOrderById($id);
            if (!$order) {
                return $this->sendError('Order not found.');
            }

            return $this->sendResponse($order, 'Order retrieved successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function createOrder(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|in:' . implode(',', Order::getStatuses()),
        ]);

        try {
            $order = $this->orderService->createOrder($data);
            return $this->sendResponse($order, 'Order created successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function updateOrder(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'nullable|in:' . implode(',', Order::getStatuses()),
        ]);

        try {
            $order = $this->orderService->updateOrder($id, $data);
            return $this->sendResponse($order, 'Order updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function deleteOrder($id)
    {
        try {
            $this->orderService->deleteOrder($id);
            return $this->sendResponse([], 'Order deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function changeOrderStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', Order::getStatuses()),
        ]);

        try {
            $order = $this->orderService->changeOrderStatus($id, $data['status']);
            return $this->sendResponse($order, 'Order status changed successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function calculateOrderTotal($id)
    {
        try {
            $total = $this->orderService->calculateOrderTotal($id);
            return $this->sendResponse(['total' => $total], 'Total calculated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
