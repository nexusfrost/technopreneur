<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'tutor_profile_id'
    ];

    public function tutor(){
        return $this->belongsTo('App\Models\User', 'tutor_profile_id');
    }
}
