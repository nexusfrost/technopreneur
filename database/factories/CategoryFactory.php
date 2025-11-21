<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_name' => fake()->word()
        ];
    }

    public function withSubjects(int $count = 3): self
    {
        return $this->afterCreating(function (\App\Models\Category $category) use ($count) {
            \App\Models\Subject::factory()->count($count)->create([
                'category_id' => $category->id,
            ]);
        });
    }

}
