<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the site 404 page with a way back home for an unknown address', function () {
    $this->get('/cette-page-nexiste-pas')
        ->assertNotFound()
        ->assertSee(__('content.error_not_found'))
        ->assertSee(route('index'));
});

it('shows the site 404 page for an unknown dossier tab', function () {
    $this->get('/pro/onglet-inconnu')
        ->assertNotFound()
        ->assertSee(__('content.error_not_found'));
});
