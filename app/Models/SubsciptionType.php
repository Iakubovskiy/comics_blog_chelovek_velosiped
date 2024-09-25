<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsciptionType extends Model
{
    use HasFactory;

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
