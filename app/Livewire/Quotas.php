<?php

namespace App\Livewire;

use App\Models\Quota;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Quotas extends Component
{
    public $answers = [];

    public function mount()
    {
        $this->answers = Auth::user()->answers->answers; 
    }

    public function updated()
    {
        Auth::user()->answers->update(['answers' => $this->answers]);
 
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.quotas', [
            'quotas' => Quota::orderBy('order')->get()
        ]);
    }
}