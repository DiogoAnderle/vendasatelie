<?php

namespace App\Livewire\Sale;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Criar Venda')]
class SaleCreate extends Component
{
    use WithPagination;

    // Class Properties
    public $search = '';
    public $quantity = 10;
    public $totalRegistros = 0;

    // Payment Properties
    public $additionOrDiscount = 0;
    public $netValue = 0;
    public $updatingValue = 0;
    public $customerId = 1;
    public $customer = '';
    public $status = 0;

    public function render()
    {

        $this->totalRegistros = Product::count();

        if ($this->updatingValue == 0) {
            $this->netValue = Cart::getTotal();
            $this->netValue = Cart::getTotal() + floatval($this->additionOrDiscount);

        }


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

    //Create Sale
    public function createSale()
    {
        $cart = Cart::getCart();
        if (count($cart) == 0) {
            $this->dispatch('msg', 'Venda não pode ser criada, carrinho vazio!', 'danger', '<i class="fas fa-exclamation-triangle"></i>');
            return;
        }

        DB::transaction(function () {
            $sale = new Sale();
            $sale->total = Cart::getTotal();
            $sale->addition_discount = $this->additionOrDiscount;
            $sale->net_value = $this->netValue;
            $sale->user_id = userID();
            $sale->customer_id = $this->customerId;
            $sale->status = $this->status;
            $sale->sale_date = date('Y-m-d');
            $sale->save();

            //agregate items on sale
            foreach (\Cart::session(userID())->getContent() as $product) {
                $item = new Item();
                $item->name = $product->name;
                $item->image = $product->associatedModel->imagem;
                $item->price = $product->price;
                $item->quantity = $product->quantity;
                $item->product_id = $product->id;
                $item->sale_date = date('Y-m-d');

                $item->save();

                $sale->items()->attach($item->id, [
                    "quantity" => $product->quantity,
                    "date_item_sale" => date('Y-m-d')
                ]);

                Product::find($product->id)->decrement('stock', $product->quantity);
            }

            Cart::clear();
            $this->reset(['additionOrDiscount', 'netValue', 'customer']);
            $this->dispatch('msg', 'Venda criada com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');;

        });
    }

    public function updatingNetValue($value)
    {
        $this->updatingValue = 1;
        $this->netValue = Cart::getTotal();
        $this->netValue = $value + floatval($this->additionOrDiscount);

    }

    #[On('add-product')]
    public function addProduct(Product $product)
    {
        Cart::add($product);
    }

    #[On('customerId')]
    public function customerId($id = 1)
    {
        $this->customerId = $id;
    }
    //Decrement Item quantity on cart
    public function decrement($id)
    {
        Cart::decrement($id);
        $this->dispatch("incrementStock.{$id}");
    }
    // Increment Item quantity on cart
    public function increment($id)
    {
        Cart::increment($id);
        $this->dispatch("decrementStock.{$id}");
    }

    //Remove Item on cart
    public function removeItem($id, $quantity)
    {
        Cart::removeItem($id);
        $this->dispatch("returnStock.{$id}", $quantity);
    }

    //Clean Cart
    public function clear()
    {
        Cart::clear();

        $this->netValue = 0;
        $this->additionOrDiscount = 0;
        $this->dispatch('msg', 'Venda cancelada com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');
        $this->dispatch('refreshProducts');

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
