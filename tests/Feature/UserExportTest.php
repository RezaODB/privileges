<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('exports admin and segmentation flags as 1 in the users export', function () {
    $admin = User::query()->create([
        'name' => 'Admin',
        'lastname' => 'User',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);

    User::query()->create([
        'order' => 7,
        'name' => 'Jane',
        'lastname' => 'Doe',
        'birthday' => '1990-02-03',
        'birthplace' => 'Liege',
        'sex' => 'f',
        'role' => 1,
        'email' => 'jane@example.com',
        'phone' => '0470000000',
        'zip' => '4000',
        'video' => true,
        'important' => true,
        'shot' => true,
        'questionnaire' => true,
        'interviewed' => true,
        'eject' => true,
        'nl' => true,
        'fr' => true,
        'repro' => true,
        'doute' => true,
        'lgtb' => true,
        'senior' => true,
        'racises' => true,
        'password' => 'password',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('users.export_users'));

    $response->assertSuccessful();
    $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

    $content = $response->streamedContent();

    expect($content)->toContain('"Video Consent";Important;Shot;Questionnaire;Interviewed;Eject;NL;FR;REPRO;DOUTE;LGTB;SENIOR;RACISES');
    expect($content)->toContain('7;2;Jane;Doe;03-02-1990;f;jane@example.com;0470000000;4000;1;1;1;1;1;1;1;1;1;1;1;1;1');
});
