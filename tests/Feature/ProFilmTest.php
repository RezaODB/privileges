<?php

use App\Models\Film;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function makeFilmAdmin(): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'films@example.com',
        'password' => Hash::make('password'),
    ]);
}

function fakeFilm(string $name = 'plaque.mp4'): UploadedFile
{
    return UploadedFile::fake()->create($name, 800, 'video/mp4');
}

it('shows the gallery of a tab to a visitor who is not signed in', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'cadre-pratique', 'order' => 1]);
    Film::factory()->for($section)->create(['title_fr' => 'Plaque 01', 'order' => 1]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Plaque 01');

    $this->assertGuest();
});

it('keeps each gallery on its own tab', function () {
    Storage::fake('public');
    $withFilms = Section::factory()->create(['slug' => 'cadre-pratique', 'order' => 1]);
    $without = Section::factory()->create(['slug' => 'about', 'order' => 2]);
    Film::factory()->for($withFilms)->create(['title_fr' => 'Plaque 01']);

    $this->get(route('pro.show', $without))->assertOk()->assertDontSee('Plaque 01');
});

it('captions a film in the language being read', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'cadre-pratique', 'order' => 1]);
    Film::factory()->for($section)->create(['title_fr' => 'Plaque 01', 'title_en' => 'Plate 01']);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))->assertOk()->assertSee('Plate 01');
    $this->get(route('pro.show', ['section' => $section, 'lang' => 'fr']))->assertOk()->assertSee('Plaque 01');
});

it('accepts a film with an optional poster and no caption at all', function () {
    Storage::fake('public');
    $this->actingAs(makeFilmAdmin());
    $section = Section::factory()->create();

    $this->post(route('sections.films.store', $section), [
        'file' => fakeFilm(),
        'poster' => UploadedFile::fake()->image('poster.jpg'),
    ])->assertRedirect(route('sections.films.index', $section));

    $film = Film::query()->sole();
    expect($film->title_fr)->toBeNull()
        ->and($film->order)->toBe(1);
    Storage::disk('public')->assertExists($film->path);
    Storage::disk('public')->assertExists($film->poster_path);
});

it('turns away a file that is not a video', function () {
    Storage::fake('public');
    $this->actingAs(makeFilmAdmin());
    $section = Section::factory()->create();

    $this->post(route('sections.films.store', $section), [
        'file' => UploadedFile::fake()->create('script.php', 10, 'application/x-php'),
    ])->assertSessionHasErrors('file');

    expect(Film::query()->count())->toBe(0);
});

it('deletes the video and its poster when the film is removed', function () {
    Storage::fake('public');
    $this->actingAs(makeFilmAdmin());
    $section = Section::factory()->create();
    $this->post(route('sections.films.store', $section), [
        'file' => fakeFilm(),
        'poster' => UploadedFile::fake()->image('poster.jpg'),
    ]);

    $film = Film::query()->sole();
    $path = $film->path;
    $poster = $film->poster_path;

    $this->from(route('sections.films.index', $section))->delete(route('films.destroy', $film));

    expect(Film::query()->count())->toBe(0);
    Storage::disk('public')->assertMissing($path);
    Storage::disk('public')->assertMissing($poster);
});

it('removes the films of a tab when the tab itself is deleted', function () {
    Storage::fake('public');
    $this->actingAs(makeFilmAdmin());
    $section = Section::factory()->create();
    Film::factory()->for($section)->create();

    $this->from(route('sections.index'))->delete(route('sections.destroy', $section));

    expect(Film::query()->count())->toBe(0);
});

it('keeps the gallery administration for administrators only', function () {
    Storage::fake('public');
    $section = Section::factory()->create();

    $this->get(route('sections.films.index', $section))->assertRedirect('/');

    $this->actingAs(User::query()->create([
        'name' => 'Jean', 'lastname' => 'Participant', 'birthday' => '1990-01-01',
        'birthplace' => 'Namur', 'sex' => 'm', 'role' => 1,
        'email' => 'participant-films@example.com', 'password' => Hash::make('password'),
    ]));

    $this->get(route('sections.films.index', $section))->assertForbidden();
});
