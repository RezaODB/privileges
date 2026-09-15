<?php

use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('opens a tab on its number, subtitle, summary and quotation', function () {
    $section = Section::factory()->create([
        'slug' => 'cadre-pratique',
        'title_fr' => 'Cadre pratique',
        'number' => '03',
        'subtitle_fr' => 'De l’idée à l’exposition.',
        'intro_fr' => 'Comment le projet prend forme, concrètement.',
        'quote_fr' => 'Rendre visible ce qui ne se voit pas.',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('03')
        ->assertSee('De l’idée à l’exposition.', escape: false)
        ->assertSee('Comment le projet prend forme, concrètement.')
        ->assertSee('Rendre visible ce qui ne se voit pas.');
});

it('sets the subtitle in the marker', function () {
    $section = Section::factory()->create([
        'slug' => 'en-bref',
        'subtitle_fr' => 'Un carrousel pour questionner l’évident.',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('<mark>Un carrousel pour questionner l’évident.</mark>', escape: false);
});

it('draws no header at all on a tab that was given none', function () {
    $section = Section::factory()->create(['slug' => 'about']);

    expect($section->hasHeader())->toBeFalse();

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertDontSee('<h1 class="font-serif', escape: false);
});

it('falls back to the french header when the english one is empty', function () {
    $section = Section::factory()->create([
        'slug' => 'cadre-theorique',
        'subtitle_fr' => 'Ce qui ne se voit pas.',
        'subtitle_en' => null,
    ]);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('Ce qui ne se voit pas.');
});
