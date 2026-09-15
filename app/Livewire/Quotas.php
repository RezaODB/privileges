<?php

namespace App\Livewire;

use App\Models\Quota;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Quotas extends Component
{
    public $answers = [];

    public $boosters = [];

    public function mount(): void
    {
        $this->answers = Auth::user()->answers?->answers ?? [];
        $this->boosters = $this->answers['boosters'] ?? [];
    }

    public function updated(): void
    {
        $this->persist();
    }

    public function submit()
    {
        $this->persist();

        session()->flash('status', 'Form saved');

        return redirect()->route('step2');
    }

    /**
     * Count the answers as the database holds them, not as the browser shows
     * them, so a participant can tell what has really been recorded.
     */
    #[Computed]
    public function savedCount(): int
    {
        $stored = Auth::user()->answers()->value('answers');

        if (! is_array($stored)) {
            return 0;
        }

        unset($stored['comment'], $stored['boosters']);

        return count($stored);
    }

    public function render()
    {
        return view('livewire.quotas', [
            'quotas' => Quota::orderBy('order')->get(),
        ]);
    }

    private function persist(): void
    {
        $answers = $this->answers;
        $answers['boosters'] = $this->boosters;

        Auth::user()->saveQuestionnaire($answers);

        unset($this->savedCount);
    }
}
