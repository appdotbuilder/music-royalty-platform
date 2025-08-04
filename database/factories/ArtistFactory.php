<?php

namespace Database\Factories;

use App\Models\Artist;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Artist>
     */
    protected $model = Artist::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = ['Pop', 'Rock', 'Hip Hop', 'R&B', 'Electronic', 'Jazz', 'Classical', 'Country', 'Reggae', 'Folk'];
        
        return [
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
            'stage_name' => fake()->firstName() . ' ' . fake()->randomElement(['Sound', 'Beats', 'Music', 'Vibes', 'Waves', 'Echo']),
            'real_name' => fake()->name(),
            'bio' => fake()->paragraph(3),
            'genres' => fake()->randomElements($genres, random_int(1, 3)),
            'country' => fake()->countryCode(),
            'avatar_url' => fake()->optional()->imageUrl(300, 300, 'people'),
            'social_links' => [
                'instagram' => fake()->optional()->url(),
                'twitter' => fake()->optional()->url(),
                'spotify' => fake()->optional()->url(),
                'youtube' => fake()->optional()->url(),
            ],
            'status' => fake()->randomElement(['active', 'inactive', 'pending']),
            'contract_signed_at' => fake()->optional(0.8)->dateTimeBetween('-2 years', 'now'),
        ];
    }

    /**
     * Indicate that the artist is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'contract_signed_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the artist is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'contract_signed_at' => null,
        ]);
    }
}