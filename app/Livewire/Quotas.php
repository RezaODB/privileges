<?php

namespace App\Livewire;

use App\Models\Quota;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Quotas extends Component
{
    public $answers = [];
    public $boosters = [];

    public function mount()
    {
        $this->answers = Auth::user()->answers->answers; 
        $this->boosters = Auth::user()->answers->answers['boosters'] ?? []; 
    }

    public function updated()
    {
        Auth::user()->answers->update([
            'answers' => $this->answers,
            'answers->boosters' => $this->boosters
        ]);
    }

    public function submit()
    {
        session()->flash('status', 'Form saved');
 
        return redirect()->route('step2');
    }

    public function render()
    {
        return view('livewire.quotas', [
            'quotas' => Quota::orderBy('order')->get()
        ]);
    }
}