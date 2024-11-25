<?php

namespace App\Http\Controllers\Admin;

use App\Services\OrderService;
use App\Services\TomService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected OrderService $orderService;
    protected TomService $tomService;

    public function __construct(OrderService $orderService, TomService $tomService)
    {
        $this->orderService = $orderService;
        $this->tomService = $tomService;
    }
    public function index(Request $request)
    {
        $filters = $request->only(['number', 'created_at_from', 'created_at_to']);
        
        $orders = $this->orderService->getAllOrders()->filter(callback: function ($order) use ($filters) {
            if (!empty($filters['number']) && !str_contains($order->number, $filters['number'])) {
                return false;
            }

            if (!empty($filters['created_at_from']) && $order->created_at < $filters['created_at_from']) {
                return false;
            }

            if (!empty($filters['created_at_to']) && $order->created_at > $filters['created_at_to']) {
                return false;
            }

            return true;
        });

        return view('admin.orders.index', compact('orders'));
    }

    public function edit(int $id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            abort(404, 'Order not found.');
        }

        $toms = $this->tomService->getAllToms();
        return view('admin.orders.edit', compact('order', 'toms'));
    }
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => 'required|string|max:255',
            'items' => 'nullable|array',
            'items.*.tom_id' => 'exists:toms,id',
            'items.*.quantity' => 'integer|min:1',
        ]);

        try {
            $order = $this->orderService->updateOrder($id, $data);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully!');
    }
}
