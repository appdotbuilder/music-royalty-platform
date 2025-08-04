<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Tenant>
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();
        
        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'domain' => fake()->optional()->domainName(),
            'description' => fake()->sentence(),
            'logo_url' => fake()->optional()->imageUrl(200, 200, 'business'),
            'website' => fake()->optional()->url(),
            'status' => fake()->randomElement(['active', 'inactive']),
            'settings' => [
                'timezone' => fake()->timezone(),
                'currency' => 'USD',
                'features' => fake()->randomElements(['analytics', 'distribution', 'royalties'], random_int(1, 3)),
            ],
        ];
    }

    /**
     * Indicate that the tenant is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the tenant is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}