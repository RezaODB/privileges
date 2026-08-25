<?php

namespace Database\Factories;

use App\Models\Film;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'section_id' => Section::factory(),
            'order' => fake()->numberBetween(1, 99),
            'title_fr' => fake()->words(2, true),
            'title_en' => fake()->words(2, true),
            'path' => 'films/'.fake()->uuid().'.mp4',
            'poster_path' => null,
        ];
    }
}
