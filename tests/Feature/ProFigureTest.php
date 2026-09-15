<?php

use App\Enums\BlockKind;
use App\Models\Chapter;
use App\Models\Figure;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeFigureAdmin(): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'figures@example.com',
        'password' => 'password',
    ]);
}

function figureBlock(Section $section): Chapter
{
    return Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Mesurer',
        'kind' => BlockKind::Figures,
        'open' => true,
        'body' => '',
    ]);
}

it('sets the figures of a block against their labels', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = figureBlock($section);

    Figure::factory()->for($block, 'chapter')->create([
        'order' => 1,
        'value_fr' => '6 %',
        'label_fr' => 'd’enfants d’origine ouvrière à l’ENA',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('6 %')
        ->assertSee('d’enfants d’origine ouvrière à l’ENA');
});

it('offers the arrow only once there are more than eight', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = figureBlock($section);

    Figure::factory()->count(8)->for($block, 'chapter')->sequence(fn ($s) => ['order' => $s->index + 1])->create();

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertDontSee(__('content.see_all_figures'));

    Figure::factory()->for($block, 'chapter')->create(['order' => 9]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee(__('content.see_all_figures'));
});

it('falls back to the french figure when the english one is empty', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = figureBlock($section);

    $figure = Figure::factory()->for($block, 'chapter')->create([
        'order' => 1,
        'value_fr' => '132 ans',
        'value_en' => null,
        'label_fr' => 'pour atteindre l’égalité de genre',
        'label_en' => 'to reach gender equality',
    ]);

    app()->setLocale('en');

    expect($figure->localizedValue())->toBe('132 ans');
    expect($figure->localizedLabel())->toBe('to reach gender equality');
});

it('takes the figures down with the block that held them', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = figureBlock($section);
    $figure = Figure::factory()->for($block, 'chapter')->create(['order' => 1]);

    $block->delete();

    expect(Figure::query()->find($figure->id))->toBeNull();
});

it('numbers a new figure after the last one', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    $block = figureBlock($section);
    Figure::factory()->for($block, 'chapter')->create(['order' => 7]);

    $this->actingAs(makeFigureAdmin())
        ->post(route('chapters.figures.store', $block), [
            'value_fr' => '16 %',
            'label_fr' => 'de taux de chômage',
        ])
        ->assertRedirect(route('chapters.figures.index', $block));

    expect($block->figures()->latest('id')->first()->order)->toBe(8);
});
