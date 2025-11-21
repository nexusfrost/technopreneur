<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "rating",
        "hourly_rate",
        "role",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function tutorProfile(){
        return $this->hasOne('App\Models\TutorProfile', 'user_id');
    }

    public function reservations(){
        return $this->hasMany(Reservation::class,'student_id');
    }

    public function notRated(){
        return $this->hasMany(Reservation::class,'student_id')->where('rating_id','=',null)->where('status','=','done');
    }

    public function unpaid(){
        return $this->hasMany(Reservation::class,'student_id')->where('status','unpaid');
    }
}
