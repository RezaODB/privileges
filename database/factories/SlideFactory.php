<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slide>
 */
class SlideFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section_id' => Section::factory(),
            'lang' => 'fr',
            'order' => fake()->numberBetween(1, 99),
            'path' => 'slides/'.fake()->uuid().'.jpg',
            'width' => 863,
            'height' => 1080,
        ];
    }

    public function english(): static
    {
        return $this->state(fn (array $attributes): array => [
            'lang' => 'en',
        ]);
    }
}
