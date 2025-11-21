<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfileSubject extends Model
{

    use HasFactory;

    protected $fillable=[
        'tutor_profile_id',
        'subject_id'
    ];
}
