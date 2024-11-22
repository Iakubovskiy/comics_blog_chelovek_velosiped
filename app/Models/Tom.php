<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tom extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'double',
        ];
    }

    public function post(){
        return $this->hasMany(Post::class);
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class, 'tom_images', 'tom_id', 'photo_id')
                ->withPivot('photo_number');
    }
}
