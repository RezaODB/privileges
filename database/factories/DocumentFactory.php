<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lang' => 'fr',
            'label' => 'Dossier de presse',
            'path' => 'documents/'.fake()->uuid().'.pdf',
            'order' => fake()->numberBetween(1, 99),
        ];
    }

    public function english(): static
    {
        return $this->state(fn (array $attributes): array => [
            'lang' => 'en',
            'label' => 'Press kit',
        ]);
    }
}
