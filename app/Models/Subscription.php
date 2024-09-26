<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';
    public $timestamps = false;
    protected $fillable =[
        'subscription_type_id',
        'beginning_date',
        'end_date',
    ];

    protected $casts = [
        'subscription_type_id' => 'integer',
        'beginning_date' => 'date',
        'end_date' => 'date',
    ];

    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class, 'subscription_type_id');
    }


    public function user(){
        return $this->belongsTo(User::class);
    }
}
