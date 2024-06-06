<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Ver Cliente')]
class CustomerShow extends Component
{
    public Customer $customer;
    public function render()
    {
        return view('livewire.customer.customer-show');
    }
}
