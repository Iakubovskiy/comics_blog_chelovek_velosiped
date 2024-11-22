<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    public function addItem(int $user_id, int $tomId, int $quantity): void
    {
        $user = User::findOrFail($user_id);
        
        $existingItem = $user->toms()->where('tom_id', $tomId)->first();

        if ($existingItem) {
            $this->updateItem($user_id, $tomId, $existingItem->pivot->quantity + $quantity);
        } else {
            $user->toms()->attach($tomId, ['quantity' => $quantity]);
        }
    }

    public function removeItem(int $user_id, int $tomId): void
    {
        $user = User::findOrFail($user_id);
        $user->toms()->detach($tomId);
    }

    public function updateItem(int $user_id, int $tomId, int $quantity): void
    {
        $user = User::findOrFail($user_id);
        
        if ($quantity <= 0) {
            $this->removeItem($user_id, $tomId);
        } else {
            $user->toms()->updateExistingPivot($tomId, ['quantity' => $quantity]);
        }
    }

    public function getItems(int $user_id): Collection
    {
        $user = User::findOrFail($user_id);
        return $user->toms()->withPivot('quantity')->get();
    }

    public function clearCart(int $user_id): void
    {
        $user = User::findOrFail($user_id);
        $user->toms()->detach();
    }

    public function getTotal(int $user_id): float
    {
        $user = User::findOrFail($user_id);
        return $user->toms->sum(function ($tom) {
            return $tom->price * $tom->pivot->quantity;
        });
    }
}
