<?php

use App\Http\EditorHtmlSanitizer;
use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps the video player Barbara embeds', function (string $source) {
    $html = app(EditorHtmlSanitizer::class)
        ->sanitize('<p><iframe width="560" height="315" src="'.$source.'" title="Teaser" frameborder="0" allowfullscreen></iframe></p>');

    expect($html)->toContain('<iframe src="'.$source.'" title="Teaser" allowfullscreen')
        ->not->toContain('width')
        ->not->toContain('frameborder');
})->with([
    'youtube' => 'https://www.youtube.com/embed/hJ29g1xezy0?si=js2azPfBs7ceSxxn',
    'youtube without cookies' => 'https://www.youtube-nocookie.com/embed/hJ29g1xezy0',
    'vimeo' => 'https://player.vimeo.com/video/123456',
]);

it('drops a frame that does not load a video player', function (string $source) {
    $html = app(EditorHtmlSanitizer::class)
        ->sanitize('<p>Avant</p><p><iframe src="'.$source.'"></iframe></p>');

    expect($html)->toBe('<p>Avant</p><p></p>');
})->with([
    'another site' => 'https://example.com/embed/abc',
    'a lookalike host' => 'https://www.youtube.com.example.com/embed/abc',
    'plain http' => 'http://www.youtube.com/embed/abc',
    'script' => 'javascript:alert(1)',
]);

it('shows a block whose text is only a video', function () {
    $section = Section::factory()->create(['slug' => 'en-bref']);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'title' => 'Voir',
        'open' => true,
        'body' => '<p><iframe src="https://www.youtube.com/embed/hJ29g1xezy0" allowfullscreen></iframe></p>',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('<iframe src="https://www.youtube.com/embed/hJ29g1xezy0"', escape: false);
});
