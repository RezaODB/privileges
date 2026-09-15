<?php

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows a chapter number and récap without opening the block', function () {
    $section = Section::factory()->create(['slug' => 'cadre-pratique']);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'number' => '01',
        'title' => 'Protocole',
        'summary' => 'Participants, déroulement, questionnaire.',
        'body' => '<p>Le détail du protocole.</p>',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('01')
        ->assertSee('Protocole')
        ->assertSee('Participants, déroulement, questionnaire.');
});

it('leaves a chapter given neither number nor récap exactly as it was', function () {
    $section = Section::factory()->create(['slug' => 'cadre-theorique']);
    Chapter::factory()->for($section)->create([
        'lang' => 'fr',
        'number' => null,
        'title' => 'Conclusion',
        'summary' => null,
        'body' => '<p>Un mot pour finir.</p>',
    ]);

    $this->get(route('pro.show', $section))
        ->assertOk()
        ->assertSee('Conclusion');
});
