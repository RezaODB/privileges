<?php

use App\Models\Section;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function makeSlideAdmin(): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'slides@example.com',
        'password' => Hash::make('password'),
    ]);
}

it('shows the carousel of a tab to a visitor who is not signed in', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Slide::factory()->for($section)->create(['path' => 'slides/premiere.jpg', 'order' => 1]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('slides/premiere.jpg', escape: false)
        ->assertSee('id="carrousel"', escape: false);

    $this->assertGuest();
});

it('keeps each carousel on its own tab', function () {
    Storage::fake('public');
    $withSlides = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    $without = Section::factory()->create(['slug' => 'about', 'order' => 2]);
    Slide::factory()->for($withSlides)->create(['path' => 'slides/premiere.jpg']);

    $this->get(route('pro.show', $without))->assertOk()->assertDontSee('slides/premiere.jpg', escape: false);
});

it('reads the carousel of the language being read', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Slide::factory()->for($section)->create(['path' => 'slides/francaise.jpg']);
    Slide::factory()->for($section)->english()->create(['path' => 'slides/english.jpg']);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('slides/english.jpg', escape: false)
        ->assertDontSee('slides/francaise.jpg', escape: false);
});

it('falls back to the french carousel when there is no english one', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Slide::factory()->for($section)->create(['path' => 'slides/francaise.jpg']);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('slides/francaise.jpg', escape: false);
});

it('does not call a tab empty when all it carries is a carousel', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Slide::factory()->for($section)->create();

    $this->get(route('pro.show', $section))->assertOk()->assertDontSee(__('content.pro_empty'));
});

it('uploads a whole carousel at once and numbers it in the order it was given', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create();

    $this->post(route('sections.slides.store', $section), [
        'lang' => 'fr',
        'files' => [
            UploadedFile::fake()->image('slide-01.jpg'),
            UploadedFile::fake()->image('slide-02.jpg'),
            UploadedFile::fake()->image('slide-03.jpg'),
        ],
    ])->assertRedirect(route('sections.slides.index', $section));

    $slides = $section->slides()->ordered()->get();
    expect($slides)->toHaveCount(3)
        ->and($slides->pluck('order')->all())->toBe([1, 2, 3])
        ->and($slides->pluck('lang')->unique()->all())->toBe(['fr']);

    $slides->each(fn (Slide $slide) => Storage::disk('public')->assertExists($slide->path));
});

it('carries on numbering when images are added to an existing carousel', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create();
    Slide::factory()->for($section)->create(['order' => 7]);

    $this->post(route('sections.slides.store', $section), [
        'lang' => 'fr',
        'files' => [UploadedFile::fake()->image('slide.jpg')],
    ]);

    expect($section->slides()->ordered()->get()->last()->order)->toBe(8);
});

it('keeps the two languages of a carousel numbered apart', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create();
    Slide::factory()->for($section)->create(['order' => 4]);

    $this->post(route('sections.slides.store', $section), [
        'lang' => 'en',
        'files' => [UploadedFile::fake()->image('slide.jpg')],
    ]);

    expect($section->slides()->forLocale('en')->sole()->order)->toBe(1);
});

it('turns away a file that is not an image', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create();

    $this->post(route('sections.slides.store', $section), [
        'lang' => 'fr',
        'files' => [UploadedFile::fake()->create('script.php', 10, 'application/x-php')],
    ])->assertSessionHasErrors('files.0');

    expect(Slide::query()->count())->toBe(0);
});

it('deletes the file along with the image it belongs to', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create();
    $this->post(route('sections.slides.store', $section), [
        'lang' => 'fr',
        'files' => [UploadedFile::fake()->image('slide.jpg')],
    ]);

    $slide = Slide::query()->sole();
    $path = $slide->path;

    $this->from(route('sections.slides.index', $section))->delete(route('slides.destroy', $slide));

    expect(Slide::query()->count())->toBe(0);
    Storage::disk('public')->assertMissing($path);
});

it('reorders an image of the carousel', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $slide = Slide::factory()->create(['order' => 1]);

    $this->patch(route('slides.update', $slide), ['order' => 5])
        ->assertRedirect(route('sections.slides.index', $slide->section));

    expect($slide->fresh()->order)->toBe(5);
});

it('removes the carousel of a tab when the tab itself is deleted', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create();
    Slide::factory()->for($section)->create();

    $this->from(route('sections.index'))->delete(route('sections.destroy', $section));

    expect(Slide::query()->count())->toBe(0);
});

it('keeps the carousel administration for administrators only', function () {
    Storage::fake('public');
    $section = Section::factory()->create();

    $this->get(route('sections.slides.index', $section))->assertRedirect('/');

    $this->actingAs(User::query()->create([
        'name' => 'Jean', 'lastname' => 'Participant', 'birthday' => '1990-01-01',
        'birthplace' => 'Namur', 'sex' => 'm', 'role' => 1,
        'email' => 'participant-slides@example.com', 'password' => Hash::make('password'),
    ]));

    $this->get(route('sections.slides.index', $section))->assertForbidden();
    $this->get(route('sections.slides.create', $section))->assertForbidden();
});

it('renders the carousel administration for an administrator', function () {
    Storage::fake('public');
    $this->actingAs(makeSlideAdmin());
    $section = Section::factory()->create(['slug' => 'en-bref', 'title_fr' => 'En bref']);
    Slide::factory()->for($section)->create();

    $this->get(route('sections.index'))->assertOk()->assertSee('image(s) de carrousel');
    $this->get(route('sections.slides.index', $section))->assertOk()->assertSee('#carrousel');
    $this->get(route('sections.slides.create', $section))->assertOk();
});
