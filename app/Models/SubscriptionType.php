<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'subscription_types';

    protected $fillable = [
        'type',
        'price',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function subsciption(){
        return $this->hasMany(Subsciption::class);
    }
}
