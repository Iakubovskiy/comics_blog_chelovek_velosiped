<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsciption extends Model
{
    use HasFactory;

    protected $fillable =[
        'subsciption_type_id',
        'beggin_date',
        'end_date',
    ];

    protected $casts = [
        'subsciption_type_id' => 'integer',
        'begin_date' => 'date',
        'end_date' => 'date',
    ];

    public function subsciptionType(){
        return $this->belongsTo(SubsciptionType::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
