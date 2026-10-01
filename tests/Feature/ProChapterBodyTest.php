<?php

use App\Models\Chapter;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeBodyAdmin(): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'body@example.com',
        'password' => 'password',
    ]);
}

it('creates a block without a body', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);

    $this->actingAs(makeBodyAdmin())
        ->post(route('sections.chapters.store', $section), [
            'lang' => 'fr',
            'title' => 'Regarder',
            'body' => '',
        ])
        ->assertSessionHasNoErrors();

    expect($section->chapters()->sole()->body)->toBe('');
});

it('lets a block lose its body', function () {
    $chapter = Chapter::factory()->create(['body' => '<p>Texte.</p>']);

    $this->actingAs(makeBodyAdmin())
        ->patch(route('chapters.update', $chapter), ['body' => ''])
        ->assertSessionHasNoErrors();

    expect($chapter->fresh()->body)->toBe('');
});

it('draws no empty paragraph for an accordion without a body', function () {
    $section = Section::factory()->create(['slug' => 'cadre-theorique']);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Conclusion',
        'body' => '',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Conclusion')
        ->assertDontSee('overflow-hidden pb-12', escape: false);
});
