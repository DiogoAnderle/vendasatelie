<?php

namespace App\Livewire\Sale;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerSale extends Component
{

    public $Id;
    public $name;
    public $occupation;
    public $email;
    public $phone_number;
    public $birth_date = '';

    public $customer = 0;
    public $customerName;

    public function render()
    {
        return view('livewire.sale.customer-sale', [
            'customers' => Customer::all(),
        ]);
    }
    public function mount()
    {
        $this->customerName();
    }
    #[On('customerId')]
    public function customerId($id = 1)
    {
        $this->customer = $id;
        $this->customerName($id);
    }
    public function customerName($id = 1)
    {
        $findCustomer = Customer::find($id);
        $this->customerName = $findCustomer->name;
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

        $this->dispatch('customerId', $customer->id);
    }

    public function openModal()
    {
        $this->dispatch('open-modal', 'modalCustomer');
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
