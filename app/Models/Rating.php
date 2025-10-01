<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'student_id',
        'tutor_id',
        'rating',
        'review'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'tutor_id');
    }
}
