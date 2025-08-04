<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Subscription>
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = fake()->randomElement(['free', 'standard', 'pro']);
        $prices = ['free' => 0, 'standard' => 29.99, 'pro' => 99.99];
        
        return [
            'tenant_id' => Tenant::factory(),
            'plan' => $plan,
            'status' => fake()->randomElement(['active', 'inactive', 'canceled']),
            'price' => $prices[$plan],
            'billing_cycle' => fake()->randomElement(['monthly', 'yearly']),
            'trial_ends_at' => fake()->optional()->dateTimeBetween('+1 week', '+1 month'),
            'current_period_start' => fake()->dateTimeBetween('-1 month', 'now'),
            'current_period_end' => fake()->dateTimeBetween('now', '+1 month'),
            'stripe_subscription_id' => fake()->optional()->regexify('sub_[A-Za-z0-9]{14}'),
            'features' => match ($plan) {
                'free' => ['basic_distribution', 'basic_analytics'],
                'standard' => ['basic_distribution', 'advanced_analytics', 'royalty_splits', '10_artists'],
                'pro' => ['premium_distribution', 'advanced_analytics', 'royalty_splits', 'unlimited_artists', 'white_label'],
                default => []
            },
        ];
    }



    /**
     * Indicate that the subscription is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that this is a pro subscription.
     */
    public function pro(): static
    {
        return $this->state(fn (array $attributes) => [
            'plan' => 'pro',
            'price' => 99.99,
            'features' => ['premium_distribution', 'advanced_analytics', 'royalty_splits', 'unlimited_artists', 'white_label'],
        ]);
    }

    /**
     * Indicate that this is a standard subscription.
     */
    public function standard(): static
    {
        return $this->state(fn (array $attributes) => [
            'plan' => 'standard',
            'price' => 29.99,
            'features' => ['basic_distribution', 'advanced_analytics', 'royalty_splits', '10_artists'],
        ]);
    }
}