<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_CREATED = 'created';
    const STATUS_SHIPPED = 'shipped'; 
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function toms()
    {
        return $this->belongsToMany(Tom::class, 'order_items', 'order_id', 'tom_id')
        ->withPivot('quantity');
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_CREATED,
            self::STATUS_SHIPPED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }
}
