<?php

use App\Models\Chapter;
use App\Models\Quota;
use App\Models\Section;
use App\Models\Theory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function makeDossierUser(int $role): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => $role,
        'email' => 'role'.$role.'@example.com',
        'password' => Hash::make('password'),
    ]);
}

it('lets a visitor read the professional dossier without signing in', function () {
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Le projet',
        'body' => '<p>Une étude socio-artistique.</p>',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Le projet')
        ->assertSee('Une étude socio-artistique.', escape: false);

    $this->assertGuest();
});

it('sends the bare /pro url to the first published tab', function () {
    Section::factory()->create(['slug' => 'about', 'order' => 9]);
    $first = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);

    $this->get(route('pro.index'))->assertRedirect(route('pro.show', $first));
});

it('hides an unpublished tab from both the url and the navigation', function () {
    $published = Section::factory()->create(['slug' => 'en-bref', 'order' => 1, 'title_fr' => 'En bref']);
    $draft = Section::factory()->unpublished()->create(['slug' => 'brouillon', 'order' => 2, 'title_fr' => 'Brouillon']);

    $this->get(route('pro.show', $draft))->assertNotFound();
    $this->get(route('pro.show', $published))->assertOk()->assertDontSee('Brouillon');
});

it('serves each tab in the language the visitor picked', function () {
    $section = Section::factory()->create([
        'slug' => 'en-bref',
        'order' => 1,
        'title_fr' => 'En bref',
        'title_en' => 'In brief',
    ]);
    Chapter::factory()->for($section)->create(['lang' => 'fr', 'title' => 'Le projet']);
    Chapter::factory()->for($section)->english()->create(['title' => 'The project']);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('In brief')
        ->assertSee('The project')
        ->assertDontSee('Le projet');

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'fr']))
        ->assertOk()
        ->assertSee('En bref')
        ->assertSee('Le projet')
        ->assertDontSee('The project');
});

it('tells the visitor when a tab has no content in their language', function () {
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Chapter::factory()->for($section)->create(['lang' => 'fr', 'title' => 'Le projet']);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee(__('content.pro_empty', [], 'en'));
});

it('keeps the tab administration out of reach of guests and participants', function () {
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);

    $this->get(route('sections.index'))->assertRedirect('/');

    $this->actingAs(makeDossierUser(role: 1));
    $this->get(route('sections.index'))->assertForbidden();
    $this->get(route('sections.chapters.index', $section))->assertForbidden();
});

it('lets an administrator create a tab and fill it with content', function () {
    $this->actingAs(makeDossierUser(role: 2));

    $this->post(route('sections.store'), [
        'title_fr' => 'Cadre théorique',
        'title_en' => 'Theoretical framework',
        'slug' => '',
        'published' => '1',
        'shows_quota' => '0',
    ])->assertRedirect(route('sections.index'));

    $section = Section::query()->sole();
    expect($section->slug)->toBe('cadre-theorique')
        ->and($section->order)->toBe(1)
        ->and($section->published)->toBeTrue();

    $this->post(route('sections.chapters.store', $section), [
        'lang' => 'fr',
        'title' => 'Introduction',
        'body' => '<p>Un texte<script>alert(1)</script></p>',
    ])->assertRedirect(route('sections.chapters.index', $section));

    $chapter = $section->chapters()->sole();
    expect($chapter->title)->toBe('Introduction')
        ->and($chapter->order)->toBe(1)
        ->and($chapter->body)->not->toContain('<script>');
});

it('refuses to give two tabs the same public address', function () {
    $this->actingAs(makeDossierUser(role: 2));
    Section::factory()->create(['slug' => 'about']);

    $this->post(route('sections.store'), [
        'title_fr' => 'About',
        'title_en' => 'About',
        'slug' => 'About',
        'published' => '1',
        'shows_quota' => '0',
    ])->assertSessionHasErrors('slug');
});

it('still renders the participant tabs for a signed-in participant', function () {
    Theory::query()->create([
        'lang' => 'fr',
        'order' => 1,
        'title' => 'Cadre théorique',
        'body' => '<p>Le contenu réservé aux participants.</p>',
    ]);

    $this->actingAs(makeDossierUser(role: 1));

    $this->get(route('step1'))
        ->assertOk()
        ->assertSee('Cadre théorique')
        ->assertSee('Le contenu réservé aux participants.', escape: false);
});

it('renders every administration screen for an administrator', function () {
    $this->actingAs(makeDossierUser(role: 2));

    $section = Section::factory()->create(['slug' => 'en-bref', 'title_fr' => 'En bref']);
    $chapter = Chapter::factory()->for($section)->create(['title' => 'Introduction']);

    $this->get(route('sections.index'))->assertOk()->assertSee('En bref')->assertSee('/pro/en-bref');
    $this->get(route('sections.create'))->assertOk();
    $this->get(route('sections.edit', $section))->assertOk()->assertSee('En bref');
    $this->get(route('sections.chapters.index', $section))->assertOk()->assertSee('Introduction');
    $this->get(route('sections.chapters.create', $section))->assertOk();
    $this->get(route('chapters.edit', $chapter))->assertOk()->assertSee('Introduction');
});

it('reorders and unpublishes a tab from the list screen', function () {
    $this->actingAs(makeDossierUser(role: 2));
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);

    $this->patch(route('sections.update', $section), ['order' => 4])
        ->assertRedirect(route('sections.index'));
    $this->patch(route('sections.update', $section), ['published' => '0'])
        ->assertRedirect(route('sections.index'));

    $section->refresh();
    expect($section->order)->toBe(4)
        ->and($section->published)->toBeFalse()
        ->and($section->slug)->toBe('en-bref');
});

it('removes the content of a tab along with the tab itself', function () {
    $this->actingAs(makeDossierUser(role: 2));
    $section = Section::factory()->create();
    Chapter::factory()->for($section)->create();

    $this->from(route('sections.index'))->delete(route('sections.destroy', $section));

    expect(Section::query()->count())->toBe(0)
        ->and(Chapter::query()->count())->toBe(0);
});

it('shows the privilege quota questionnaire read only, on the tabs that ask for it', function () {
    Quota::query()->create([
        'question_fr' => 'Je peux marcher seul le soir sans crainte.',
        'question_en' => 'I can walk alone at night without fear.',
        'order' => 1,
    ]);

    $plain = Section::factory()->create(['slug' => 'about', 'order' => 2]);
    $annexe = Section::factory()->create(['slug' => 'annexe-1', 'order' => 1, 'shows_quota' => true]);

    $this->get(route('pro.show', $annexe))
        ->assertOk()
        ->assertSee('Je peux marcher seul le soir sans crainte.')
        ->assertSee('disabled', escape: false)
        ->assertDontSee('wire:model', escape: false)
        ->assertDontSee('<form', escape: false);

    $this->get(route('pro.show', $plain))
        ->assertOk()
        ->assertDontSee('Je peux marcher seul le soir sans crainte.');
});

it('never writes to the participant tables when the quota is displayed', function () {
    $quota = Quota::query()->create(['question_fr' => 'Une question.', 'order' => 1]);
    $section = Section::factory()->create(['shows_quota' => true]);

    $before = $quota->updated_at;
    $this->get(route('pro.show', $section))->assertOk();

    expect(Quota::query()->count())->toBe(1)
        ->and($quota->fresh()->updated_at->eq($before))->toBeTrue()
        ->and(App\Models\Answer::query()->count())->toBe(0);
});

it('falls back to the french question when the english one is missing', function () {
    Quota::query()->create(['question_fr' => 'Question sans traduction.', 'question_en' => null, 'order' => 1]);
    $section = Section::factory()->create(['shows_quota' => true]);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('Question sans traduction.');
});
