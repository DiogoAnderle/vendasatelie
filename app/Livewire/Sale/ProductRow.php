<?php

namespace App\Livewire\Sale;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductRow extends Component
{
    public Product $product;

    protected function getListeners()
    {
        return [   
            "refreshProducts" => "mount",
        ];
    }
    public function render()
    {
        return view('livewire.sale.product-row');
    }

    public function addProduct(Product $product)
    {

        $this->dispatch('add-product', $product);
    }

}
