<?php

namespace App\Enums;

enum BlockKind: string
{
    case Text = 'text';
    case Slides = 'slides';
    case Films = 'films';
    case Podcasts = 'podcasts';
    case Figures = 'figures';

    /**
     * What Barbara reads in the admin when choosing what a block shows.
     */
    public function label(): string
    {
        return match ($this) {
            self::Text => 'Texte seul',
            self::Slides => 'Le carrousel de l’onglet',
            self::Films => 'Les vidéos du bloc',
            self::Podcasts => 'Les podcasts',
            self::Figures => 'Les chiffres du bloc',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $kind): array => [$kind->value => $kind->label()])
            ->all();
    }
}
