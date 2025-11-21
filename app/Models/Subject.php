<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- 1. Added this import

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id' // <-- 3. Added category_id to fillable
    ];

    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'tutor_profile_id');
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class); // <-- 2. Closed the function
    }
}