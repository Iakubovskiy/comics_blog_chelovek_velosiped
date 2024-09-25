<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'Description',
        'tom_id',
        'chapter_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'tom_id' => 'integer',
        'chapter_id' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }

    public function tom(){
        return $this->belongsTo(Tom::class);
    }

    public function image(){
        return $this->hasMany(PostImage::class);
    }
}
