<?php

use App\Models\Chapter;
use App\Models\Film;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows a film filed under a chapter inside that chapter, not in the tab gallery', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    $chapter = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'number' => 'A',
        'title' => 'Patchwork photographique',
    ]);

    Film::factory()->for($section)->create([
        'chapter_id' => $chapter->id,
        'title_fr' => 'Ambrotype n°12',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Ambrotype n°12');

    expect($chapter->films)->toHaveCount(1);
    expect($section->films()->onTheTab()->count())->toBe(0);
});

it('leaves a film with no chapter in the tab gallery', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    Film::factory()->for($section)->create(['title_fr' => 'Coulisses']);

    expect($section->films()->onTheTab()->count())->toBe(1);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Coulisses');
});

it('keeps the films when the chapter holding them is deleted', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    $chapter = Chapter::factory()->for($section)->create(['lang' => 'fr']);
    $film = Film::factory()->for($section)->create(['chapter_id' => $chapter->id]);

    $chapter->delete();

    expect($film->fresh()->chapter_id)->toBeNull();
    expect($section->films()->onTheTab()->count())->toBe(1);
});

it('shows the french gallery on the english page when the english chapter has none', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);

    $french = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'number' => 'A',
        'title' => 'Patchwork photographique',
    ]);
    $english = Chapter::factory()->for($section)->create([
        'lang' => 'en',
        'number' => 'A',
        'title' => 'Photographic patchwork',
    ]);

    Film::factory()->for($section)->create([
        'chapter_id' => $french->id,
        'title_fr' => 'Ambrotype n°12',
        'title_en' => 'Ambrotype no. 12',
    ]);

    expect($english->displayedFilms())->toHaveCount(1);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('Ambrotype no. 12');
});

it('prefers the english gallery when the english chapter has one of its own', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);

    $french = Chapter::factory()->for($section)->create(['lang' => 'fr', 'number' => 'A']);
    $english = Chapter::factory()->for($section)->create(['lang' => 'en', 'number' => 'A']);

    Film::factory()->for($section)->create(['chapter_id' => $french->id, 'title_fr' => 'Version FR']);
    Film::factory()->for($section)->create(['chapter_id' => $english->id, 'title_en' => 'English cut']);

    expect($english->displayedFilms())->toHaveCount(1);
    expect($english->displayedFilms()->first()->title_en)->toBe('English cut');
});

it('matches twins within their own parent, not across parents', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);

    $frenchParent = Chapter::factory()->for($section)->create(['lang' => 'fr', 'number' => '02']);
    $otherParent = Chapter::factory()->for($section)->create(['lang' => 'fr', 'number' => '03']);
    $englishParent = Chapter::factory()->for($section)->create(['lang' => 'en', 'number' => '02']);

    $frenchChild = Chapter::factory()->for($section)->create([
        'lang' => 'fr', 'number' => 'A', 'parent_id' => $frenchParent->id,
    ]);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr', 'number' => 'A', 'parent_id' => $otherParent->id,
    ]);
    $englishChild = Chapter::factory()->for($section)->create([
        'lang' => 'en', 'number' => 'A', 'parent_id' => $englishParent->id,
    ]);

    expect($englishChild->frenchTwin()?->id)->toBe($frenchChild->id);
});

it('holds the extra videos behind an arrow when the block sets a limit', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Coulisses',
        'kind' => App\Enums\BlockKind::Films,
        'open' => true,
        'films_visible' => 3,
        'body' => '',
    ]);

    Film::factory()->count(3)->for($section)->create(['chapter_id' => $block->id]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertDontSee(__('content.see_all_films'));

    Film::factory()->for($section)->create(['chapter_id' => $block->id]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee(__('content.see_all_films'));
});

it('shows every video when the block sets no limit', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'kind' => App\Enums\BlockKind::Films,
        'open' => true,
        'films_visible' => null,
        'body' => '',
    ]);

    Film::factory()->count(6)->for($section)->create(['chapter_id' => $block->id]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertDontSee(__('content.see_all_films'));
});
