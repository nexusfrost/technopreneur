<?php

    namespace Database\Factories;

use App\Models\Subject;
use App\Models\TutorProfile;
use App\Models\TutorProfileSubject;
use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\Factory;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
     */
    class TutorProfileFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition(): array
        {
            return [
                'name' => fake()->name(),
                'bio' => fake()->paragraph(3,3),
                'education' => fake()->words(3),
                'teaching_experience' => random_int(1,5),
                'hourly_rate' => random_int(10,100),
                'is_active' => 1,
                'rating' => 3,
                'user_id' => User::inRandomOrder()->first()
            ];
        }

        public function configure(): static{
            return $this->afterCreating(function (TutorProfile $user)  {
                TutorProfileSubject::factory()->create([
                    'tutor_profile_id' => $user->id,
                ]);
            });
        }
    }
