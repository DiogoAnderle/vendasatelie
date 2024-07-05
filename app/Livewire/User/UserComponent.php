<?php

namespace App\Livewire\User;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Usuários')]
class UserComponent extends Component
{
    //Trait
    use WithPagination;
    use WithFileUploads;

    //Propriedades de Classe
    public $search = '';
    public $totalRegistros = 0;
    public $quantity = 15;

    //Propriedades de Modelo
    public $Id = 0;
    public $name;
    public $email;
    public $password;
    public $re_password;
    public $admin;
    public $active = true;
    public $image;
    public $imageModel;

    public function render()
    {
        $this->totalRegistros = User::count();

        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->quantity);

        return view('livewire.user.user-component', compact('users'));
    }
    public function create()
    {
        $this->Id = 0;
        $this->cleanFormFields();
        $this->dispatch('open-modal', 'modalUser');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:5',
            're_password' => 'required|same:password',
            'image' => 'image|max:1024|nullable',

        ];
        $messages = [
            're_password.required' => 'Campo confirmar senha é obrigatório conferem',
            're_password.same' => 'Campo senha e confirmar senha não conferem',
            "email.unique" => 'Email já utilizado.',
        ];

        $this->validate($rules, $messages);

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);
        $user->admin = $this->admin;
        $user->active = $this->active;

        $user->save();

        if ($this->image) {
            $customName = 'users/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $user->image()->create(['url' => $customName]);
        }

        $this->dispatch('close-modal', 'modalUser');
        $this->dispatch('msg', 'Usuário criado com sucesso.','success', '<i class="fas fa-check-circle"></i>');
        $this->cleanFormFields();
    }

    public function edit(User $user)
    {
        $this->cleanFormFields();

        $this->Id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->admin = $user->admin ? true : false;
        $this->active = $user->active ? true : false;
        $this->imagemModel = $user->image ? $user->image->url : null;

        $this->dispatch('open-modal', 'modalUser');
    }

    public function update(User $user)
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => ['required', Rule::unique('users')->ignore($this->Id)],
            'password' => 'min:5|nullable',
            're_password' => 'same:password',
            'image' => 'image|max:1024|nullable',
        ];
        $messages = [
            "email.unique" => 'Email já utilizado.',
        ];

        $this->validate($rules, $messages);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->admin = $this->admin;
        $user->active = $this->active;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }


        $user->update();

        if ($this->image) {
            if ($user->image != null) {
                Storage::delete('public/' . $user->image->url);
                $user->image()->delete();
            }
            $customName = 'users/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $user->image()->create(['url' => $customName]);
        }

        $this->dispatch('close-modal', 'modalUser');
        $this->dispatch('msg', 'Usuário editado com sucesso.','success', '<i class="fas fa-check-circle"></i>');
        $this->cleanFormFields();
    }




    #[On('destroyUser')]
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $hasSale = Sale::where('user_id', '=', $id)->get();
        if ($hasSale->count() > 0) {
            $this->dispatch('msg', 'Usuário não pode ser removido. Possui ' . $hasSale->count() . ' vendas vinculadas', 'warning', '<i class="fas fa-exclamation-triangle"></i>');
            return;

        } else {
            if ($user->image != null) {
                Storage::delete('public/' . $user->image->url);
                $user->image()->delete();
            }

            $user->delete();
            $this->dispatch('msg', 'Usuário removido com sucesso.','success', '<i class="fas fa-check-circle"></i>');
        }
    }


    public function cleanFormFields()
    {
        $this->reset([
            'Id',
            'name',
            'email',
            'password',
            're_password',
            'admin',
            'active',
            'image',
            'imageModel'
        ]);
        $this->resetErrorBag();

    }
}
