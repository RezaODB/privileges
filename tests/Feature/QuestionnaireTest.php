<?php

use App\Livewire\Quotas;
use App\Models\Quota;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function makeParticipant(): User
{
    return User::query()->create([
        'order' => 1,
        'name' => 'Adam',
        'lastname' => 'Welling',
        'birthday' => '1974-10-21',
        'birthplace' => 'NA',
        'sex' => 'male',
        'role' => 1,
        'email' => 'participant@example.com',
        'password' => 'password',
    ]);
}

function makeQuestions(int $count = 3): array
{
    return collect(range(1, $count))
        ->map(fn (int $order): Quota => Quota::query()->create([
            'question_fr' => "Question {$order}",
            'question_en' => "Question {$order}",
            'category' => 'Sécurité',
            'order' => $order,
        ]))
        ->all();
}

it('stores the whole questionnaire from a plain form submit', function () {
    $participant = makeParticipant();
    [$first, $second, $third] = makeQuestions();

    $participant->answers()->create(['answers' => [], 'votes' => []]);

    $this->actingAs($participant)
        ->post(route('answers.store'), [
            'answers' => [
                $first->id => 'always',
                $second->id => 'never',
                $third->id => 'sometimes',
            ],
            'boosters' => [$second->id],
            'comment' => 'Merci pour cette étude',
        ])
        ->assertRedirect(route('step2'))
        ->assertSessionHas('status');

    expect($participant->fresh()->answers->answers)->toBe([
        (string) $first->id => 'always',
        (string) $second->id => 'never',
        (string) $third->id => 'sometimes',
        'boosters' => [(string) $second->id],
        'comment' => 'Merci pour cette étude',
    ]);
});

it('creates the answer row when a participant never had one', function () {
    $participant = makeParticipant();
    [$first] = makeQuestions(1);

    expect($participant->answers)->toBeNull();

    $this->actingAs($participant)
        ->post(route('answers.store'), ['answers' => [$first->id => 'often']])
        ->assertRedirect(route('step2'));

    expect($participant->fresh()->answers->answers)->toBe([
        (string) $first->id => 'often',
        'boosters' => [],
    ]);
});

it('leaves the votes already cast untouched', function () {
    $participant = makeParticipant();
    [$first] = makeQuestions(1);

    $participant->answers()->create(['answers' => [], 'votes' => [7 => 'yes']]);

    $this->actingAs($participant)
        ->post(route('answers.store'), ['answers' => [$first->id => 'rarely']]);

    expect($participant->fresh()->answers->votes)->toBe(['7' => 'yes']);
});

it('refuses an answer outside the offered scale', function () {
    $participant = makeParticipant();
    [$first] = makeQuestions(1);

    $participant->answers()->create(['answers' => [], 'votes' => []]);

    $this->actingAs($participant)
        ->post(route('answers.store'), ['answers' => [$first->id => 'maybe']])
        ->assertSessionHasErrors('answers.'.$first->id);

    expect($participant->fresh()->answers->answers)->toBe([]);
});

it('refuses more than three boosters', function () {
    $participant = makeParticipant();
    $questions = makeQuestions(4);

    $participant->answers()->create(['answers' => [], 'votes' => []]);

    $this->actingAs($participant)
        ->post(route('answers.store'), [
            'boosters' => collect($questions)->pluck('id')->all(),
        ])
        ->assertSessionHasErrors('boosters');
});

it('turns a guest away from the store route', function () {
    $this->post(route('answers.store'), ['answers' => []])->assertRedirect('/');
});

it('saves through livewire as soon as an answer is clicked', function () {
    $participant = makeParticipant();
    [$first] = makeQuestions(1);

    $participant->answers()->create(['answers' => [], 'votes' => []]);

    Livewire::actingAs($participant)
        ->test(Quotas::class)
        ->set('answers.'.$first->id, 'often');

    expect($participant->fresh()->answers->answers)->toBe([
        (string) $first->id => 'often',
        'boosters' => [],
    ]);
});

it('saves through livewire when the form is submitted', function () {
    $participant = makeParticipant();
    [$first, $second] = makeQuestions(2);

    $participant->answers()->create(['answers' => [], 'votes' => []]);

    Livewire::actingAs($participant)
        ->test(Quotas::class)
        ->set('answers', [$first->id => 'always', $second->id => 'never'])
        ->call('submit')
        ->assertRedirect(route('step2'));

    expect($participant->fresh()->answers->answers)->toBe([
        (string) $first->id => 'always',
        (string) $second->id => 'never',
        'boosters' => [],
    ]);
});

it('counts only the answers the database really holds', function () {
    $participant = makeParticipant();
    [$first, $second] = makeQuestions(2);

    $participant->answers()->create([
        'answers' => [$first->id => 'always', 'boosters' => [(string) $second->id], 'comment' => 'Bonjour'],
        'votes' => [],
    ]);

    Livewire::actingAs($participant)
        ->test(Quotas::class)
        ->assertSee('1 réponse(s) sur 2');
});

it('renders the saved answers in the markup so the form survives without javascript', function () {
    $participant = makeParticipant();
    [$first, $second] = makeQuestions(2);

    $participant->answers()->create([
        'answers' => [$first->id => 'often', 'boosters' => [(string) $second->id], 'comment' => 'Bonjour'],
        'votes' => [],
    ]);

    $html = Livewire::actingAs($participant)->test(Quotas::class)->html();

    expect($html)
        ->toContain('name="answers['.$first->id.']" value="often" checked')
        ->toContain('name="boosters[]" value="'.$second->id.'" checked')
        ->toContain('>Bonjour</textarea>')
        ->toContain('method="POST"');
});
