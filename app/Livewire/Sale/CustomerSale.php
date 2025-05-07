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
     * Selected customer ID (this should match the property in SaleEdit)
     *
     * @var int
     */
    public $customer_id = 0;

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
     * @param int|null $customerId
     * @return void
     */
    public function mount($customerId = null)
    {
        if ($customerId) {
            $this->customer_id = $customerId;
            $this->customerName($customerId);
            $this->dispatch('customerId', $customerId); // Emite o evento com o ID do cliente da venda
        } else {
            $this->customerName(); // Carrega o nome do cliente padrão (ID 1)
            $this->dispatch('customerId', 1); // Emite o evento com o ID padrão
        }
    }

    /**
     * Handle the customerId event (this is triggered by the select change in the view)
     *
     * @param int $id
     * @return void
     */
    #[On('customerId')]
    public function updateCustomerIdFromSelect($id)
    {
        $this->customer_id = $id;
        $this->customerName($id);
        // Não precisamos mais emitir o evento aqui, pois o SaleEdit já tem a propriedade $customer_id atualizada pelo wire:model
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