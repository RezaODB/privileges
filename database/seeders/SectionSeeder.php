<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

/**
 * Creates the tabs of the professional dossier without touching anything else.
 *
 * Safe to run more than once: existing tabs are matched on their slug and left untouched.
 */
class SectionSeeder extends Seeder
{
    /**
     * @var list<array{slug: string, title_fr: string, title_en: string}>
     */
    private const array SECTIONS = [
        ['slug' => 'en-bref', 'title_fr' => 'En bref', 'title_en' => 'In brief'],
        ['slug' => 'cadre-theorique', 'title_fr' => 'Cadre théorique', 'title_en' => 'Theoretical framework'],
        ['slug' => 'cadre-pratique', 'title_fr' => 'Cadre pratique', 'title_en' => 'Practical framework'],
        ['slug' => 'annexe-1-quota-de-privileges', 'title_fr' => 'Annexe 1: Quota de privilèges', 'title_en' => 'Appendix 1: Privilege quota'],
        ['slug' => 'annexe-2-elements-de-comprehension', 'title_fr' => 'Annexe 2: Éléments de compréhension', 'title_en' => 'Appendix 2: Background elements'],
        ['slug' => 'about', 'title_fr' => 'About', 'title_en' => 'About'],
    ];

    public function run(): void
    {
        foreach (self::SECTIONS as $index => $section) {
            Section::firstOrCreate(
                ['slug' => $section['slug']],
                [
                    'title_fr' => $section['title_fr'],
                    'title_en' => $section['title_en'],
                    'order' => $index + 1,
                    'published' => true,
                ]
            );
        }
    }
}
