<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'tom_id'
    ];
    public function tom(){
        return $this->belongsTo(Tom::class);
    }

    public function post(){
        return $this->hasMany(Post::class);
    }
}
