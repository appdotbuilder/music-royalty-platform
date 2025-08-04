<?php

namespace Database\Factories;

use App\Models\RoyaltySplit;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoyaltySplit>
 */
class RoyaltySplitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\RoyaltySplit>
     */
    protected $model = RoyaltySplit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'work_id' => Work::factory(),
            'user_id' => User::factory(),
            'role' => fake()->randomElement(['artist', 'writer', 'producer', 'publisher', 'label']),
            'percentage' => fake()->randomFloat(2, 5, 50),
            'split_type' => fake()->randomElement(['master', 'publishing']),
            'notes' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['active', 'inactive', 'pending']),
        ];
    }

    /**
     * Indicate that the royalty split is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Create artist split with higher percentage.
     */
    public function artist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'artist',
            'percentage' => fake()->randomFloat(2, 40, 70),
            'status' => 'active',
        ]);
    }

    /**
     * Create label split.
     */
    public function label(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'label',
            'percentage' => fake()->randomFloat(2, 20, 40),
            'status' => 'active',
        ]);
    }
}