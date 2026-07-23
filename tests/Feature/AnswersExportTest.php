<?php

use App\Models\Quota;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function makeAdmin(): User
{
    return User::query()->create([
        'name' => 'Admin',
        'lastname' => 'User',
        'birthday' => '1980-01-01',
        'birthplace' => 'Brussels',
        'sex' => 'f',
        'role' => 2,
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);
}

it('exports every participant answer set as a single row', function () {
    $admin = makeAdmin();

    $first = Quota::query()->create([
        'question_fr' => 'Je peux marcher seul la nuit',
        'category' => 'Sécurité',
        'order' => 1,
    ]);

    $second = Quota::query()->create([
        'question_fr' => 'On me demande mes papiers',
        'category' => 'Sécurité',
        'order' => 2,
    ]);

    $participant = User::query()->create([
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
        'important' => true,
        'eject' => true,
        'password' => 'password',
    ]);

    $participant->answers()->create([
        'answers' => [
            $first->id => 'never',
            $second->id => 'often',
            'boosters' => [(string) $second->id],
            'comment' => 'Merci pour cette étude',
        ],
        'votes' => [
            1 => 'yes',
            'comment' => 'Un avis sur la loterie',
        ],
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('users.export_answers'));

    $response->assertSuccessful();
    $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

    $content = $response->streamedContent();

    expect($content)->toContain('Answered;Boosters;Comment;"Vote Comment"');
    expect($content)->toContain('"1. Je peux marcher seul la nuit";"2. On me demande mes papiers"');
    expect($content)->toContain('7;2;Jane;Doe;03-02-1990;f;jane@example.com;0470000000;4000;2/2;2;"Merci pour cette étude";"Un avis sur la loterie"');
    expect($content)->toContain('NEVER;OFTEN');
});

it('marks boosters in the single participant export', function () {
    $admin = makeAdmin();

    $quota = Quota::query()->create([
        'question_fr' => 'Je peux marcher seul la nuit',
        'category' => 'Sécurité',
        'order' => 1,
    ]);

    $participant = User::query()->create([
        'order' => 7,
        'name' => 'Jane',
        'lastname' => 'Doe',
        'birthday' => '1990-02-03',
        'birthplace' => 'Liege',
        'sex' => 'f',
        'role' => 1,
        'email' => 'jane@example.com',
        'password' => 'password',
    ]);

    $participant->answers()->create([
        'answers' => [
            $quota->id => 'never',
            'boosters' => [(string) $quota->id],
        ],
        'votes' => [],
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('users.export', $participant));

    $response->assertSuccessful();

    expect($response->streamedContent())->toContain('1;Sécurité;"Je peux marcher seul la nuit";NEVER;1');
});

it('leaves administrators out of the answers export', function () {
    $admin = makeAdmin();

    Quota::query()->create([
        'question_fr' => 'Une question',
        'category' => 'Divers',
        'order' => 1,
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('users.export_answers'));

    $response->assertSuccessful();

    expect($response->streamedContent())->not->toContain('admin@example.com');
});

it('exports a participant who never answered', function () {
    $admin = makeAdmin();

    Quota::query()->create([
        'question_fr' => 'Une question',
        'category' => 'Divers',
        'order' => 1,
    ]);

    User::query()->create([
        'order' => 3,
        'name' => 'Marc',
        'lastname' => 'Roux',
        'birthday' => '1988-05-05',
        'birthplace' => 'Namur',
        'sex' => 'm',
        'role' => 1,
        'email' => 'marc@example.com',
        'password' => 'password',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('users.export_answers'));

    $response->assertSuccessful();

    expect($response->streamedContent())->toContain('marc@example.com');
    expect($response->streamedContent())->toContain('0/1');
});

it('refuses the answers export to a participant', function () {
    $participant = User::query()->create([
        'name' => 'Jane',
        'lastname' => 'Doe',
        'birthday' => '1990-02-03',
        'birthplace' => 'Liege',
        'sex' => 'f',
        'role' => 1,
        'email' => 'jane@example.com',
        'password' => 'password',
    ]);

    $this->actingAs($participant)
        ->get(route('users.export_answers'))
        ->assertForbidden();
});
