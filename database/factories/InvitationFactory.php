<?php

namespace Database\Factories;

use App\Models\Invitation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Invitation>
     */
    protected $model = Invitation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'invited_by' => User::factory(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->randomElement(['artist', 'label_admin']),
            'token' => Str::random(32),
            'status' => fake()->randomElement(['pending', 'accepted', 'expired', 'canceled']),
            'metadata' => [
                'invited_artist_name' => fake()->optional()->name(),
                'message' => fake()->optional()->sentence(),
            ],
            'expires_at' => fake()->dateTimeBetween('now', '+2 weeks'),
            'accepted_at' => fake()->optional(0.3)->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the invitation is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'accepted_at' => null,
            'expires_at' => fake()->dateTimeBetween('now', '+2 weeks'),
        ]);
    }

    /**
     * Indicate that the invitation was accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'accepted',
            'accepted_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create artist invitation.
     */
    public function artist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'artist',
        ]);
    }
}