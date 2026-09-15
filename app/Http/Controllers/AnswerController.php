<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Models\Quota;
use Illuminate\Http\RedirectResponse;

class AnswerController extends Controller
{
    /**
     * Store the whole questionnaire in a single request.
     *
     * The form also saves on every click through Livewire, but those calls are
     * lost when the browser cannot reach the server. This plain submit is the
     * path that always works, so a participant never leaves with answers that
     * only ever existed in their browser.
     */
    public function store(StoreAnswerRequest $request): RedirectResponse
    {
        $questionIds = Quota::query()->pluck('id')->map(strval(...))->all();

        $answers = collect($request->validated('answers', []))
            ->only($questionIds)
            ->all();

        $answers['boosters'] = array_map(strval(...), $request->validated('boosters', []));

        if (filled($request->validated('comment'))) {
            $answers['comment'] = $request->validated('comment');
        }

        $request->user()->saveQuestionnaire($answers);

        return redirect()->route('step2')->with('status', 'Form saved');
    }
}
