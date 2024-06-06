<?php

namespace App\Livewire\Sale;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Vendas')]
class SaleCreate extends Component
{
    use WithPagination;

    // Propriedades de classe
    public $search = '';
    public $quantity = 10;
    public $totalRegistros = 0;

    public function render()
    {

        $this->totalRegistros = Product::count();

        return view(
            'livewire.sale.sale-create',
            [
                'products' => $this->products,
                'cart' => Cart::getCart(),
                'total' => Cart::getTotal(),
                'totalItems' => Cart::totalItems(),
            ]
        );
    }

    #[On('add-product')]
    public function addProduct(Product $product)
    {
        Cart::add($product);
    }
    //Decrement Item on cart
    public function decrement($id)
    {
        Cart::decrement($id);
        $this->dispatch("incrementStock.{$id}");
    }
    // Increment Item on cart
    public function increment($id)
    {
        Cart::increment($id);
        $this->dispatch("decrementStock.{$id}");
    }

    //Remove Item on cart
    public function removeItem($id)
    {
        Cart::removeItem($id);
    }

    //Clean Cart
    public function clear()
    {
        Cart::clear();
        $this->dispatch('msg', 'Venda Cancelada');
    }

    #[Computed()]
    public function products()
    {
        return Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('sale_price', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate($this->quantity);
    }
}
