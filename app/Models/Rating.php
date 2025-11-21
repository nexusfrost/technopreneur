<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    use HasFactory;

    protected $fillable = [
        'student_id',
        'tutor_profile_id',
        'reservation_id',
        'rating',
        'review'
    ];

    public function tutor(){
        return $this->belongsTo(TutorProfile::class, 'tutor_profile_id');
    }

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
}
