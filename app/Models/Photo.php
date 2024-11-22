<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'url',
    ];

    public function post(){
        return $this->belongsToMany(Post::class, 'post_images', 'photo_id', 'post_id')
                ->withPivot('photo_number');
    }
    
    public function toms()
    {
        return $this->belongsToMany(Tom::class, 'tom_images', 'photo_id', 'tom_id')
                ->withPivot('photo_number');
    }
}
