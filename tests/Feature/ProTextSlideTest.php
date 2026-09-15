<?php

use App\Models\Section;
use App\Models\Slide;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('sets a written slide in the carousel, question in the marker', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);

    Slide::factory()->for($section)->create([
        'lang' => 'fr',
        'order' => 1,
        'path' => null,
        'title' => 'Avez-vous déjà hésité devant la couleur d’un pansement ?',
        'body' => '<p>Pendant près d’un siècle.</p>',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('<mark>Avez-vous déjà hésité devant la couleur d’un pansement ?</mark>', escape: false)
        ->assertSee('Pendant près d’un siècle.', escape: false);
});

it('lets written and uploaded slides sit in the same carousel', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);

    $written = Slide::factory()->for($section)->create([
        'lang' => 'fr', 'order' => 1, 'path' => null, 'title' => 'Une question', 'body' => '<p>Un texte.</p>',
    ]);
    $uploaded = Slide::factory()->for($section)->create([
        'lang' => 'fr', 'order' => 2, 'path' => 'slides/one.jpg',
    ]);

    expect($written->isText())->toBeTrue();
    expect($written->url())->toBeNull();
    expect($uploaded->isText())->toBeFalse();

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Une question')
        ->assertSee('slides/one.jpg', escape: false);
});

it('keeps the highlighter Barbara puts inside a slide', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);

    $this->actingAs(makeSlideAdmin())
        ->post(route('sections.slides.storeText', $section), [
            'lang' => 'fr',
            'title' => 'Une question',
            'body' => '<p>Des peines <mark>20 % plus longues</mark>.</p>',
        ])
        ->assertRedirect(route('sections.slides.index', $section));

    expect($section->slides()->sole()->body)->toContain('<mark>20 % plus longues</mark>');
});

it('numbers a written slide after the last one of its language', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    Slide::factory()->for($section)->create(['lang' => 'fr', 'order' => 4, 'path' => 'slides/a.jpg']);
    Slide::factory()->for($section)->create(['lang' => 'en', 'order' => 9, 'path' => 'slides/b.jpg']);

    $this->actingAs(makeSlideAdmin())
        ->post(route('sections.slides.storeText', $section), [
            'lang' => 'fr',
            'body' => '<p>Un texte.</p>',
        ]);

    expect($section->slides()->forLocale('fr')->max('order'))->toBe(5);
});

it('deletes a written slide without reaching for a file that was never there', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $slide = Slide::factory()->for($section)->create(['lang' => 'fr', 'order' => 1, 'path' => null, 'body' => '<p>x</p>']);

    $this->actingAs(makeSlideAdmin())
        ->delete(route('slides.destroy', $slide));

    expect(Slide::query()->find($slide->id))->toBeNull();
});
