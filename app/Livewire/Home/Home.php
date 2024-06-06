<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Inicio')]
class Home extends Component
{
    public function render()
    {
        return view('livewire.home.home');
    }
}
