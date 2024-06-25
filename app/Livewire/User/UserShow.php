<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Ver do Usuário')]
class UserShow extends Component
{
    use WithPagination;
    public User $user;
    public function render()
    {
        $sales = $this->user->sales()->paginate(5);
        return view('livewire.user.user-show', compact('sales'));
    }
}
