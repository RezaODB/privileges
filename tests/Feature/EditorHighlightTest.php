<?php

use App\Http\EditorHtmlSanitizer;

it('keeps the highlighter Barbara applies in the editor', function () {
    $html = app(EditorHtmlSanitizer::class)
        ->sanitize('<p>Avez-vous déjà hésité devant <mark>la couleur d’un pansement</mark> ?</p>');

    expect($html)->toContain('<mark>la couleur d’un pansement</mark>');
});

it('strips the styling a pasted highlight drags along with it', function () {
    $html = app(EditorHtmlSanitizer::class)
        ->sanitize('<p><mark style="background:#f0f" onclick="steal()">Surligné</mark></p>');

    expect($html)->toContain('<mark>Surligné</mark>')
        ->not->toContain('style')
        ->not->toContain('onclick');
});
