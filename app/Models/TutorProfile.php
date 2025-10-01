<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    protected $fillable = [
        'name',
        'bio',
        'education',
        'teaching_experience',
        'hourly_rate',
        'is_active',
        'rating',
    ];

    public function availabilities(){
        return $this->hasMany('App\Models\Availability');
    }
}
