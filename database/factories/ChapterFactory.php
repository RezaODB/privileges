<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chapter>
 */
class ChapterFactory extends Factory
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
            'title' => fake()->sentence(3),
            'body' => '<p>'.fake()->paragraph().'</p>',
        ];
    }

    public function english(): static
    {
        return $this->state(fn (array $attributes): array => [
            'lang' => 'en',
        ]);
    }
}
