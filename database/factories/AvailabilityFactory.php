<?php

namespace Database\Factories;

use App\Models\TutorProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('08:00:00', '16:00:00');

        // 2. Generate an end time that is 1 to 3 hours after the start time
        $endTime = (clone $startTime)->modify('+' . $this->faker->numberBetween(1, 3) . ' hours');

        return [
            // This is the line that answers your question
            'day_of_week' => $this->faker->randomElement([
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ]),

            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),

            // Automatically create or get a TutorProfile to associate with
            'tutor_profile_id' => TutorProfile::inRandomOrder()->first(),
        ];
    }
}
