<?php

namespace App\Http\Controllers\UserPart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $items = $this->cartService->getItems(auth()->id());
        $total = $this->cartService->getTotal(auth()->id());
        return view('cart.index', compact('items', 'total'));
    }

    public function addToCart(Request $request)
{
    $tom_id = $request->input('tom_id');
    $quantity = $request->input('quantity', 1);
    $this->cartService->addItem(auth()->id(), $tom_id, $quantity);
    return redirect()->route('toms.index')->with('success', 'Tom created successfully.');
}


    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'tom_id' => 'required|exists:toms,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $this->cartService->updateItem(auth()->id(), $validated['tom_id'], $validated['quantity']);
        return redirect()->route('cart.index')->with('success', 'Кількість товару оновлено');
    }

    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'tom_id' => 'required|exists:toms,id',
        ]);
        
        $this->cartService->removeItem(auth()->id(), $validated['tom_id']);
        return redirect()->route('cart.index')->with('success', 'Товар видалено з кошика');
    }
    public function clearCart()
    {
        $this->cartService->clearCart(auth()->id());
        return redirect()->route('cart.index')->with('success', 'Кошик очищено');
    }

}
