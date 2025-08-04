<?php

namespace Database\Factories;

use App\Models\Artist;
use App\Models\Tenant;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Work>
     */
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genres = ['Pop', 'Rock', 'Hip Hop', 'R&B', 'Electronic', 'Jazz', 'Classical', 'Country', 'Reggae', 'Folk'];
        $platforms = ['Spotify', 'Apple Music', 'YouTube Music', 'Amazon Music', 'Tidal', 'Deezer'];
        
        return [
            'tenant_id' => Tenant::factory(),
            'artist_id' => Artist::factory(),
            'title' => fake()->sentence(random_int(1, 3)),
            'isrc' => 'US' . fake()->numerify('####') . fake()->numerify('######'),
            'upc' => fake()->optional()->numerify('############'),
            'genres' => fake()->randomElements($genres, random_int(1, 2)),
            'language' => fake()->randomElement(['en', 'es', 'fr', 'de', 'it']),
            'duration_seconds' => fake()->numberBetween(120, 360),
            'release_date' => fake()->dateTimeBetween('-2 years', '+3 months'),
            'album_name' => fake()->optional(0.3)->sentence(random_int(1, 2)),
            'cover_art_url' => fake()->imageUrl(600, 600, 'abstract'),
            'audio_file_url' => fake()->optional()->url(),
            'metadata' => [
                'producer' => fake()->name(),
                'songwriter' => fake()->name(),
                'label' => fake()->company(),
                'copyright' => '℗ ' . fake()->year() . ' ' . fake()->company(),
            ],
            'status' => fake()->randomElement(['draft', 'pending_review', 'approved', 'distributed', 'takedown']),
            'distribution_platforms' => fake()->randomElements($platforms, random_int(3, 6)),
            'distributed_at' => fake()->optional(0.7)->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that the work is distributed.
     */
    public function distributed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'distributed',
            'distributed_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the work is pending review.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending_review',
            'distributed_at' => null,
        ]);
    }
}