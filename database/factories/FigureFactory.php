<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Figure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Figure>
 */
class FigureFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chapter_id' => Chapter::factory(),
            'order' => fake()->numberBetween(1, 99),
            'value_fr' => fake()->numberBetween(1, 99).' %',
            'label_fr' => fake()->sentence(6),
        ];
    }
}
