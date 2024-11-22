<?php
namespace App\Http\Controllers\API;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends BaseController
{
    public function __construct(protected CartService $cartService){}

    public function getUserCart(int $id)
    {
        $carts = $this->cartService->getItems($id);
            return $this->sendResponse($carts, 'Carts retrieved successfully');
    }

    public function addItemToCard(Request $request)
    {
        try {
            $cartData = [                
                'name' => $request->input('name'),
            ];

            $this->cartService->addItem($request->input('user_id'), $request->input('tom_id'),$request->input('quantity'));
            return $this->sendResponse(null,message:'Item successfully added');
        } catch (\Exception $e) {
            return $this->sendError('Failed to create Cart', ['error' => $e->getMessage()]);
        }
    }

    public function updateItem(Request $request, int $id)
    {
        try {

            $this->cartService->updateItem($request->input('user_id'), $request->input('tom_id'),$request->input('quantity'));
            return $this->sendResponse(null, 'Cart updated successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to update Cart', ['error' => $e->getMessage()]);
        }
    }

    public function clearCart(int $id)
    {
        try {
            $this->cartService->clearCart($id);
            return $this->sendResponse(null, 'Cart cleared successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to delete Cart', ['error' => $e->getMessage()]);
        }
    } 
}
