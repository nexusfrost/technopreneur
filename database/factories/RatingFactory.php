<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\TutorProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => User::inRandomOrder()->first(),
            'rating' => random_int(1,5),
            'review' => fake()->paragraph(3,3),
            'tutor_profile_id' => 102,
            'reservation_id' => Reservation::inRandomOrder()->first()
        ];
    }
}
