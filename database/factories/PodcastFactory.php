<?php

namespace Database\Factories;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Podcast>
 */
class PodcastFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lang' => 'fr',
            'order' => fake()->numberBetween(1, 99),
            'title' => fake()->sentence(3),
            'guest' => null,
            'duration' => fake()->numberBetween(10, 60).' min',
            'path' => 'podcasts/'.fake()->uuid().'.mp3',
        ];
    }

    public function english(): static
    {
        return $this->state(fn (array $attributes): array => ['lang' => 'en']);
    }
}
