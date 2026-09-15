<?php

use App\Models\Chapter;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeChapterAdmin(): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'chapters@example.com',
        'password' => 'password',
    ]);
}

it('files a sub-chapter inside its parent instead of the main list', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);

    $scenography = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'number' => '02',
        'title' => 'Scénographie',
        'body' => '<p>La scénographie dans son ensemble.</p>',
    ]);

    Chapter::factory()->for($section)->create([
        'parent_id' => $scenography->id,
        'lang' => 'fr',
        'number' => 'A',
        'title' => 'Patchwork photographique',
        'summary' => '250 portraits au collodion humide',
        'body' => '<p>Le détail du patchwork.</p>',
    ]);

    $response = $this->get(route('pro.show', $section))->assertOk();

    $response->assertSee('Patchwork photographique')
        ->assertSee('250 portraits au collodion humide')
        ->assertSee('Le détail du patchwork.', escape: false);

    expect($scenography->children)->toHaveCount(1);
    expect($section->chapters()->topLevel()->count())->toBe(1);
});

it('refuses a parent from another tab', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    $elsewhere = Chapter::factory()->create(['lang' => 'fr']);

    $this->actingAs(makeChapterAdmin())
        ->post(route('sections.chapters.store', $section), [
            'lang' => 'fr',
            'title' => 'Patchwork',
            'body' => '<p>Texte.</p>',
            'parent_id' => $elsewhere->id,
        ])
        ->assertSessionHasErrors('parent_id');
});

it('refuses a parent in another language', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    $french = Chapter::factory()->for($section)->create(['lang' => 'fr']);

    $this->actingAs(makeChapterAdmin())
        ->post(route('sections.chapters.store', $section), [
            'lang' => 'en',
            'title' => 'Patchwork',
            'body' => '<p>Text.</p>',
            'parent_id' => $french->id,
        ])
        ->assertSessionHasErrors('parent_id');
});

it('keeps the tree two levels deep', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    $parent = Chapter::factory()->for($section)->create(['lang' => 'fr']);
    $child = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'parent_id' => $parent->id,
    ]);

    $this->actingAs(makeChapterAdmin())
        ->post(route('sections.chapters.store', $section), [
            'lang' => 'fr',
            'title' => 'Trop profond',
            'body' => '<p>Texte.</p>',
            'parent_id' => $child->id,
        ])
        ->assertSessionHasErrors('parent_id');
});

it('takes the sub-chapters down with the parent', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    $parent = Chapter::factory()->for($section)->create(['lang' => 'fr']);
    $child = Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'parent_id' => $parent->id,
    ]);

    $this->actingAs(makeChapterAdmin())
        ->delete(route('chapters.destroy', $parent));

    expect(Chapter::query()->find($child->id))->toBeNull();
});
