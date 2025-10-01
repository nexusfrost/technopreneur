<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'student_id',
        'tutor_id',
        'start_time',
        'end_time',
        'status',
        'price'
    ];
}
