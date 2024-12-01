<?php

namespace App\Http\Controllers\UserPart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CartService;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;

    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $orders = $this->orderService->getUserOrders(auth()->id());

        return view('orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = $this->orderService->getOrderById($id);

        if ($order->user_id !== auth()->id()) {
            abort(403, 'Ви не маєте доступу до цього замовлення.');
        }

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderService->createOrder([
                'user_id' => auth()->id(),
                'status' => Order::STATUS_CREATED
            ]);
            $cartItems = $this->cartService->getItems(auth()->id());
            foreach ($cartItems as $item) {
                $order->toms()->attach($item->id, [
                    'quantity' => $item->pivot->quantity
                ]);
            }
            $this->cartService->clearCart(auth()->id());
            DB::commit();
            return redirect()->route('orders.show', $order->id)
                           ->with('success', 'Замовлення успішно створено!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Помилка при створенні замовлення. Спробуйте пізніше.');
        }
    }
}
