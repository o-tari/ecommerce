<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WelcomeHeader extends Component
{
    public function render()
    {
        return view('livewire.welcome-header', [
            'user' => Auth::user(),
        ]);
    }
}
