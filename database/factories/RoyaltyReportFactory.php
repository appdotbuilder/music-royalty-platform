<?php

namespace Database\Factories;

use App\Models\RoyaltyReport;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoyaltyReport>
 */
class RoyaltyReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\RoyaltyReport>
     */
    protected $model = RoyaltyReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $platforms = ['Spotify', 'Apple Music', 'YouTube Music', 'Amazon Music', 'Tidal', 'Deezer'];
        $platform = fake()->randomElement($platforms);
        $streams = fake()->numberBetween(10000, 1000000);
        $ratePerStream = fake()->randomFloat(6, 0.003, 0.007);
        
        return [
            'tenant_id' => Tenant::factory(),
            'platform' => $platform,
            'period_start' => fake()->dateTimeBetween('-6 months', '-1 month'),
            'period_end' => fake()->dateTimeBetween('-1 month', 'now'),
            'total_streams' => $streams,
            'total_revenue' => $streams * $ratePerStream,
            'platform_data' => [
                'territory' => fake()->countryCode(),
                'currency' => 'USD',
                'report_id' => fake()->uuid(),
                'generated_at' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            ],
            'status' => fake()->randomElement(['pending', 'processed', 'paid']),
            'processed_at' => fake()->optional(0.8)->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Indicate that the report is processed.
     */
    public function processed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processed',
            'processed_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Create Spotify report.
     */
    public function spotify(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => 'Spotify',
        ]);
    }

    /**
     * Create Apple Music report.
     */
    public function appleMusic(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => 'Apple Music',
        ]);
    }
}