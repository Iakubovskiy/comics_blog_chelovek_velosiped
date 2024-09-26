<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tom extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function chapter()
    {
        return $this->hasMany(Chapter::class);
    }
}
