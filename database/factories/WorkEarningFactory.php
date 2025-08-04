<?php

namespace Database\Factories;

use App\Models\RoyaltyReport;
use App\Models\Work;
use App\Models\WorkEarning;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkEarning>
 */
class WorkEarningFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\WorkEarning>
     */
    protected $model = WorkEarning::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $platforms = ['Spotify', 'Apple Music', 'YouTube Music', 'Amazon Music', 'Tidal', 'Deezer'];
        $streams = fake()->numberBetween(1000, 100000);
        $ratePerStream = fake()->randomFloat(6, 0.003, 0.007);
        
        return [
            'work_id' => Work::factory(),
            'royalty_report_id' => RoyaltyReport::factory(),
            'platform' => fake()->randomElement($platforms),
            'streams' => $streams,
            'revenue' => $streams * $ratePerStream,
            'rate_per_stream' => $ratePerStream,
            'territory' => fake()->randomElement(['WW', 'US', 'GB', 'CA', 'AU', 'DE', 'FR']),
            'period_start' => fake()->dateTimeBetween('-3 months', '-1 month'),
            'period_end' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Create high-earning work.
     */
    public function highEarning(): static
    {
        $streams = fake()->numberBetween(50000, 500000);
        $ratePerStream = fake()->randomFloat(6, 0.005, 0.008);
        
        return $this->state(fn (array $attributes) => [
            'streams' => $streams,
            'revenue' => $streams * $ratePerStream,
            'rate_per_stream' => $ratePerStream,
        ]);
    }

    /**
     * Create Spotify earning.
     */
    public function spotify(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => 'Spotify',
            'rate_per_stream' => fake()->randomFloat(6, 0.003, 0.005),
        ]);
    }
}