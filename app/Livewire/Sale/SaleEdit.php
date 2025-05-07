<?php

namespace App\Livewire\Sale;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Product;
use App\Models\Sale;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Vendas')]
class SaleEdit extends Component
{
    use WithPagination;


    // Class Properties
    public $search = '';
    public $quantity = 15;
    public $totalRegistros = 0;

    public Sale $sale;

    public $cart;

    public $loadCart = false;
    public function render()
    {
        if (!$this->loadCart) {
            $this->getItemsToCart();
        } else {
            $this->cart = Cart::getCart();
        }

        $this->totalRegistros = Product::count();

        return view('livewire.sale.sale-edit', [
            'products' => $this->products,
            'totalItems' => Cart::totalItems(),
            'total' => Cart::getTotal(),
        ]);
    }

    public function editSale()
    {
        $this->sale->total = Cart::getTotal();
        $this->sale->net_value = $this->sale->total;

        $this->sale->update();

        $itemsIds = [];

        foreach ($this->sale->items as $item) {
            $item->delete();
        }

        foreach (Cart::getCart() as $product) {
            $item = new Item();
            $item->name = $product->name;
            $item->price = $product->price;
            $item->quantity = $product->quantity;
            $item->image = $product->associatedModel->imagem;
            $item->product_id = $product->id;
            $item->sale_date = date('Y-m-d');
            $item->save();

            $itemsIds += [$item->id => ['quantity' => $product->quantity, 'date_item_sale' => date('Y-m-d')]];
        }
        $this->sale->items()->sync($itemsIds);
        $this->dispatch('msg', 'Venda editada corretamente', 'success', '<i class="fas fa-check-circle"></i>');

    }

    public function mount()
    {
        //$this->cart = collect();
    }

    // Add Item on cart
    #[On('add-product')]
    public function addProduct(Product $product)
    {
        Cart::add($product);
    }
    #[On('quantityUpdated')]
    public function updateQuantity($productId, $newQuantity)
    {
        $newQuantity = intval($newQuantity);

        if ($newQuantity <= 0) {
            \Cart::session(userId())->remove($productId);
            $this->updatingValue = 0;
            return;
        }

        $cartItem = \Cart::session(userId())->get($productId);
        if (!$cartItem) return;

        \Cart::session(userId())->update($productId, [
            'quantity' => [
                'relative' => false,
                'value' => $newQuantity,
            ],
        ]);

        $this->updatingValue = 0;
    }

    // Decrement Item quantity on cart
    public function decrement($id)
    {
        Cart::decrement($id);
       
    }
    // Increment Item quantity on cart
    public function increment($id)
    {
        Cart::increment($id);
       
    }

    public function removeItem($id, $quantity)
    {
        Cart::removeItem($id);
       
    }

    public function getItemsToCart()
    {
        foreach ($this->sale->items as $item) {
            $product = Product::find($item->product_id);
            $existingItem = \Cart::session(userId())->get($item->product_id);

            if ($existingItem) {
                $this->cart = Cart::getCart();
                return;
            } else {
                \Cart::session(userId())->add([
                    'id' => $item->product_id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'attributes' => [],
                    'associatedModel' => $product,
                ]);
            }
        }
        $this->cart = Cart::getCart();
        $this->loadCart = true;
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
