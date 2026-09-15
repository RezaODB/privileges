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
