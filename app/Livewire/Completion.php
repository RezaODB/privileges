<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Completion extends Component
{
    public $completion = [];

    public function mount()
    {
        $this->completion = Auth::user()->answers->completion ?? [];
        
        $this->completion[1] = Auth::user() ? true : false;
    }

    public function updated()
    {
        Auth::user()?->answers->update(['completion' => $this->completion]);
    }

    public function render()
    {
        return view('livewire.completion');
    }
}
