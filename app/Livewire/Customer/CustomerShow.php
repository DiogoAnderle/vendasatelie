<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Ver Cliente')]
class CustomerShow extends Component
{
    use WithPagination;
    public Customer $customer;
    public function render()
    {
        $sales = $this->customer->sales()->paginate(5);
        return view('livewire.customer.customer-show', compact('sales'));
    }
}
