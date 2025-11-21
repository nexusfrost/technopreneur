<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'education',
        'teaching_experience',
        'hourly_rate',
        'is_active',
        'rating',
        'user_id',
        'balance'
    ];

    public function availabilities(){
        $daySortOrder = "
            CASE day_of_week
                WHEN 'Monday' THEN 1
                WHEN 'Tuesday' THEN 2
                WHEN 'Wednesday' THEN 3
                WHEN 'Thursday' THEN 4
                WHEN 'Friday' THEN 5
                WHEN 'Saturday' THEN 6
                WHEN 'Sunday' THEN 7
            END
        ";

        return $this->hasMany('App\Models\Availability')
                    ->orderByRaw($daySortOrder);
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\Subject','tutor_profile_subjects','tutor_profile_id','subject_id');
    }

    public function ratings(){
        return $this->hasMany(Rating::class,'tutor_profile_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class,'tutor_profile_id');
    }


}
