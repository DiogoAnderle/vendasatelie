<?php

namespace App\Livewire\Sale;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * CustomerSale Livewire component
 */
class CustomerSale extends Component
{
    /**
     * Customer ID
     *
     * @var int
     */
    public $Id;

    /**
     * Customer name
     *
     * @var string
     */
    public $name;

    /**
     * Customer occupation
     *
     * @var string
     */
    public $occupation;

    /**
     * Customer email
     *
     * @var string
     */
    public $email;

    /**
     * Customer phone number
     *
     * @var string
     */
    public $phone_number;

    /**
     * Customer birth date
     *
     * @var string
     */
    public $birth_date = '';

    /**
     * Selected customer ID
     *
     * @var int
     */
    public $customer = 0;

    /**
     * Selected customer name
     *
     * @var string
     */
    public $customerName;

    /**
     * Render the view for the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.sale.customer-sale', [
            'customers' => Customer::all(),
        ]);
    }

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount()
    {
        $this->customerName();
    }

    /**
     * Handle the customerId event
     *
     * @param int $id
     * @return void
     */
    #[On('customerId')]
    public function customerId($id = 1)
    {
        $this->customer = $id;
        $this->customerName($id);
    }

    /**
     * Get the customer name by ID
     *
     * @param int $id
     * @return void
     */
    public function customerName($id = 1)
    {
        $findCustomer = Customer::find($id);
        $this->customerName = $findCustomer->name;
    }

    /**
     * Store a new customer
     *
     * @return void
     */
    public function store()
    {
        // Define validation rules
        $rules = [
            'name' => 'required|min:3|max:255|unique:customers',
            'email' => 'email|max:255',
            'occupation' => 'max:255'
        ];

        // Validate the form data
        $this->validate($rules);

        // Create a new customer instance
        $customer = new Customer();

        // Set the customer properties
        $customer->name = $this->name;
        $customer->occupation = $this->occupation;
        $customer->email = $this->email;
        $customer->phone_number = $this->phone_number;
        $customer->birth_date = $this->birth_date;

        // Save the customer
        $customer->save();

        // Clean the form fields
        $this->cleanFormFields();

        // Dispatch events
        $this->dispatch('close-modal', 'modalCustomer');
        $this->dispatch('msg', 'Cliente criado com sucesso.');

        $this->dispatch('customerId', $customer->id);
    }

    /**
     * Open the customer modal
     *
     * @return void
     */
    public function openModal()
    {
        $this->dispatch('open-modal', 'modalCustomer');
    }

    /**
     * Clean the form fields and error bag
     *
     * @return void
     */
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