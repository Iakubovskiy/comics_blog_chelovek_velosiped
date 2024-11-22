<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'Description',
        'tom_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'tom_id' => 'integer',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tom(){
        return $this->belongsTo(Tom::class);
    }

    public function images(){
        return $this->belongsToMany(Photo::class, 'post_images', 'post_id', 'photo_id')
                ->withPivot('photo_number');
    }
}
