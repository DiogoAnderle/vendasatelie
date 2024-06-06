<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Clientes')]
class CustomerComponent extends Component
{
    //Trait
    use WithPagination;
    //Propriedades de Classe
    public $search = '';
    public $totalRegistros = 0;
    public $quantity = 15;

    //Propriedades de Modelo
    public $Id;
    public $name;
    public $occupation;
    public $email;
    public $phone_number;
    public $birth_date = '';
    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $this->totalRegistros = Customer::count();

        $customers = Customer::where('name', 'like', '%' . $this->search . '%')->orWhere('id', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->quantity);

        return view('livewire.customer.customer-component', compact('customers'));
    }

    public function create()
    {
        $this->cleanFormFields();
        $this->Id = 0;
        $this->dispatch('open-modal', 'modalCustomer');
    }


    public function store()
    {
        $rules = [
            'name' => 'required|min:3|max:255|unique:customers',
            'email' => 'email|max:255',
            'occupation' => 'max:255'
        ];


        $this->validate($rules);

        $customer = new Customer();

        $customer->name = $this->name;
        $customer->occupation = $this->occupation;
        $customer->email = $this->email;
        $customer->phone_number = $this->phone_number;
        $customer->birth_date = $this->birth_date;

        $customer->save();

        $this->cleanFormFields();

        $this->dispatch('close-modal', 'modalCustomer');
        $this->dispatch('msg', 'Cliente criado com sucesso.');
    }

    public function edit(Customer $customer)
    {
        $this->cleanFormFields();

        $this->Id = $customer->id;
        $this->name = $customer->name;
        $this->occupation = $customer->occupation;
        $this->email = $customer->email;
        $this->phone_number = $customer->phone_number;
        if ($customer->birth_date != null) {
            $this->birth_date = date('d/m/Y', strtotime($customer->birth_date));
        } else {
            $this->birth_date = '';
        }

        $this->dispatch('open-modal', 'modalCustomer');
    }


    public function update(Customer $customer)
    {
        $rules = [
            'name' => ['required', 'min:3', 'max:255', Rule::unique('customers')->ignore($this->Id)],
            'email' => 'email|max:255',
            'occupation' => 'max:255'
        ];

        $this->validate($rules);

        $customer->name = $this->name;
        $customer->occupation = $this->occupation;
        $customer->email = $this->email;
        $customer->phone_number = $this->phone_number;
        $customer->birth_date = $this->birth_date;

        $customer->update();

        $this->dispatch('close-modal', 'modalCustomer');
        $this->dispatch('msg', 'Cliente editado com sucesso.');
        $this->cleanFormFields();
    }

    #[On('destroyCustomer')]
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        $this->dispatch('msg', 'Cliente removido com sucesso.');
    }

    public function cleanFormFields()
    {
        $this->reset([
            'Id',
            'name',
            'occupation',
            'email',
            'phone_number',
            'birth_date',
        ]);
        $this->resetErrorBag();
    }
}
