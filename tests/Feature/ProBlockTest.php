<?php

use App\Enums\BlockKind;
use App\Models\Chapter;
use App\Models\Film;
use App\Models\Section;
use App\Models\Slide;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lays an always-open block out flat, with no button to open it', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'number' => '01',
        'title' => 'Lire',
        'subtitle' => 'Un carrousel pour questionner l’évident.',
        'summary' => '17 images, 17 questions.',
        'open' => true,
        'body' => '',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Lire')
        ->assertSee('<mark>Un carrousel pour questionner l’évident.</mark>', escape: false)
        ->assertSee('17 images, 17 questions.')
        ->assertDontSee('(+ Open)');
});

it('leaves a chapter that is not always-open as an accordion', function () {
    $section = Section::factory()->create(['slug' => 'cadre-theorique']);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Conclusion',
        'open' => false,
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('(+ Open)');
});

it('lets a block claim the carousel so it is not drawn twice', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    Slide::factory()->for($section)->create(['lang' => 'fr', 'order' => 1]);

    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Lire',
        'kind' => BlockKind::Slides,
        'open' => true,
        'body' => '',
    ]);

    $response = $this->get(route('pro.show', $section))->assertOk();

    expect(substr_count($response->getContent(), 'id="carrousel"'))->toBe(0);
    expect(substr_count($response->getContent(), 'content.previous') + substr_count($response->getContent(), 'Précédent'))->toBe(1);
});

it('draws the tab carousel when no block claims it', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    Slide::factory()->for($section)->create(['lang' => 'fr', 'order' => 1]);

    $response = $this->get(route('pro.show', $section))->assertOk();

    expect(substr_count($response->getContent(), 'id="carrousel"'))->toBe(1);
});

it('shows a block its own films', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Coulisses',
        'kind' => BlockKind::Films,
        'open' => true,
        'body' => '',
    ]);
    Film::factory()->for($section)->create([
        'chapter_id' => $block->id,
        'title_fr' => 'Making-of du collodion',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Making-of du collodion');
});
