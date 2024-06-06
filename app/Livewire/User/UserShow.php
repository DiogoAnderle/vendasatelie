<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ver do Usuário')]
class UserShow extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.user.user-show');
    }
}
