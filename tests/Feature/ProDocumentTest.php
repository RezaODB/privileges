<?php

use App\Models\Document;
use App\Models\Section;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function makeDocumentAdmin(): User
{
    return User::query()->create([
        'name' => 'Barbara',
        'lastname' => 'Iweins',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'documents@example.com',
        'password' => Hash::make('password'),
    ]);
}

function fakePdf(string $name = 'dossier.pdf', int $kilobytes = 40): UploadedFile
{
    return UploadedFile::fake()->create($name, $kilobytes, 'application/pdf');
}

it('offers only the documents of the language being read', function () {
    Storage::fake('public');
    $section = Section::factory()->create(['slug' => 'en-bref', 'order' => 1]);
    Document::factory()->create(['label' => 'Dossier complet', 'order' => 1]);
    Document::factory()->english()->create(['label' => 'Full dossier', 'order' => 1]);

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'fr']))
        ->assertOk()
        ->assertSee('Dossier complet')
        ->assertDontSee('Full dossier');

    $this->get(route('pro.show', ['section' => $section, 'lang' => 'en']))
        ->assertOk()
        ->assertSee('Full dossier')
        ->assertDontSee('Dossier complet');
});

it('lets a visitor download a document without signing in', function () {
    Storage::fake('public');
    $this->actingAs(makeDocumentAdmin());
    $this->post(route('documents.store'), [
        'lang' => 'fr',
        'label' => 'Dossier complet',
        'file' => fakePdf(),
    ])->assertRedirect(route('documents.index'));

    $document = Document::query()->sole();
    Storage::disk('public')->assertExists($document->path);

    auth()->logout();
    $this->get(route('pro.document', $document))
        ->assertOk()
        ->assertDownload('dossier-complet-FR.pdf');
});

it('turns away anything that is not a pdf', function () {
    Storage::fake('public');
    $this->actingAs(makeDocumentAdmin());

    $this->post(route('documents.store'), [
        'lang' => 'fr',
        'label' => 'Faux',
        'file' => UploadedFile::fake()->create('virus.php', 10, 'application/x-php'),
    ])->assertSessionHasErrors('file');

    expect(Document::query()->count())->toBe(0);
});

it('replaces the file and deletes the previous one', function () {
    Storage::fake('public');
    $this->actingAs(makeDocumentAdmin());
    $this->post(route('documents.store'), ['lang' => 'fr', 'label' => 'Dossier', 'file' => fakePdf('v1.pdf')]);

    $document = Document::query()->sole();
    $firstPath = $document->path;

    $this->patch(route('documents.update', $document), ['file' => fakePdf('v2.pdf')])
        ->assertRedirect(route('documents.index'));

    $document->refresh();
    expect($document->path)->not->toBe($firstPath);
    Storage::disk('public')->assertMissing($firstPath);
    Storage::disk('public')->assertExists($document->path);
});

it('keeps the current file when the label alone is edited', function () {
    Storage::fake('public');
    $this->actingAs(makeDocumentAdmin());
    $this->post(route('documents.store'), ['lang' => 'fr', 'label' => 'Dossier', 'file' => fakePdf()]);

    $document = Document::query()->sole();
    $path = $document->path;

    $this->patch(route('documents.update', $document), ['label' => 'Dossier de presse']);

    $document->refresh();
    expect($document->label)->toBe('Dossier de presse')
        ->and($document->path)->toBe($path);
    Storage::disk('public')->assertExists($path);
});

it('deletes the file from disk along with the document', function () {
    Storage::fake('public');
    $this->actingAs(makeDocumentAdmin());
    $this->post(route('documents.store'), ['lang' => 'fr', 'label' => 'Dossier', 'file' => fakePdf()]);

    $document = Document::query()->sole();
    $path = $document->path;

    $this->from(route('documents.index'))->delete(route('documents.destroy', $document));

    expect(Document::query()->count())->toBe(0);
    Storage::disk('public')->assertMissing($path);
});

it('returns 404 when the file has vanished from disk', function () {
    Storage::fake('public');
    $document = Document::factory()->create();

    $this->get(route('pro.document', $document))->assertNotFound();
});

it('keeps document administration for administrators only', function () {
    Storage::fake('public');
    $document = Document::factory()->create();

    $this->get(route('documents.index'))->assertRedirect('/');

    $this->actingAs(User::query()->create([
        'name' => 'Jean', 'lastname' => 'Participant', 'birthday' => '1990-01-01',
        'birthplace' => 'Namur', 'sex' => 'm', 'role' => 1,
        'email' => 'participant@example.com', 'password' => Hash::make('password'),
    ]));

    $this->get(route('documents.index'))->assertForbidden();
    $this->delete(route('documents.destroy', $document))->assertForbidden();
});
