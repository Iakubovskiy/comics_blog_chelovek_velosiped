<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'title',
        'Description',
        'tom_id',
    ];

    protected $casts = [
        'tom_id' => 'integer',
    ];

    public function tom(){
        return $this->belongsTo(Tom::class);
    }

    public function images(){
        return $this->belongsToMany(Photo::class, 'post_images', 'post_id', 'photo_id')
                ->withPivot('photo_number');
    }
}
