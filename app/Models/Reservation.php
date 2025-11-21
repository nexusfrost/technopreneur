<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{

    use HasFactory;
    protected $fillable = [
        'student_id',
        'tutor_profile_id',
        'start_time',
        'end_time',
        'status',
        'price',
        'meeting_link',
        'rating_id',
        'reservation_date'

    ];

    public function tutor(){
        return $this->BelongsTo(TutorProfile::class,'tutor_profile_id');
    }

    public function student(){
        return $this->BelongsTo(User::class,'student_id');
    }

    public function rating(){
        return $this->hasOne(Rating::class,'reservation_id');
    }
}
