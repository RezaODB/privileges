<?php

namespace App\Livewire;

use App\Models\Vote;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Votes extends Component
{
    public $votes = [];

    public function mount()
    {
        $this->votes = Auth::user()->answers->votes ?? []; 
    }

    public function updated()
    {
        Auth::user()->answers->update(['votes' => $this->votes]);
    }

    public function render()
    {
        return view('livewire.votes', [
            'questions' => Vote::orderBy('order')->get()
        ]);
    }
}