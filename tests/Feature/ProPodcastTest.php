<?php

use App\Enums\BlockKind;
use App\Models\Chapter;
use App\Models\Podcast;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps the four podcasts that were hard-coded in the template', function () {
    expect(Podcast::query()->count())->toBe(4);
    expect(Podcast::query()->forLocale('fr')->ordered()->pluck('path')->all())
        ->toBe(['theory.mp3', 'practice.mp3']);
});

it('serves a file uploaded since from the media disk, and the originals from the public root', function () {
    $original = Podcast::query()->where('path', 'theory.mp3')->sole();
    $uploaded = Podcast::factory()->create(['path' => 'podcasts/abc.mp3']);

    expect($original->url())->toBe(asset('theory.mp3'));
    expect($uploaded->url())->toContain('podcasts/abc.mp3')
        ->and($uploaded->url())->not->toBe(asset('podcasts/abc.mp3'));
});

it('sets a podcast under its guest and its length', function () {
    $section = Section::factory()->create(['slug' => 'en-bref', 'shows_podcasts' => true]);

    Podcast::query()->where('path', 'theory.mp3')->update([
        'title' => 'Cadre théorique',
        'guest' => 'Avec Nathalie Achard',
        'duration' => '24 min',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Cadre théorique')
        ->assertSee('Avec Nathalie Achard')
        ->assertSee('24 min');
});

it('serves the english list on the english page', function () {
    $section = Section::factory()->create(['slug' => 'en-bref', 'shows_podcasts' => true]);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('Theoretical framework')
        ->assertDontSee('Cadre théorique');
});

it('draws the same waveform for a podcast every time, and a different one per podcast', function () {
    $first = Podcast::factory()->create(['id' => 101]);
    $second = Podcast::factory()->create(['id' => 102]);

    expect($first->waveform())->toHaveCount(48)
        ->and($first->waveform())->toBe($first->waveform())
        ->and($first->waveform())->not->toBe($second->waveform());
});

it('lets a block claim the podcasts so the tab does not repeat them', function () {
    $section = Section::factory()->create(['slug' => 'en-bref', 'shows_podcasts' => true]);

    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Écouter',
        'kind' => BlockKind::Podcasts,
        'open' => true,
        'body' => '',
    ]);

    $response = $this->get(route('pro.show', $section))->assertOk();

    expect(substr_count($response->getContent(), 'theory.mp3'))->toBe(1);
});
