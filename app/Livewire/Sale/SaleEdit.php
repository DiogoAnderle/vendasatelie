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

#[Title('Editar Venda')]
class SaleEdit extends Component
{
    use WithPagination;

    // Class Properties
    public $search = '';
    public $registers = 15;
    public $totalRegistros = 0;
    public array $productsInCartIds = [];

    public Sale $sale;
    public $customer_id; // Para armazenar o ID do cliente selecionado
    public $loadCart = false;

    public function render()
    {
        $this->totalRegistros = Product::count();

        return view('livewire.sale.sale-edit', [
            'products' => $this->products,
            'cart' => Cart::getCart(),
            'totalItems' => Cart::totalItems(),
            'total' => Cart::getTotal(),
        ]);
    }

    public function mount(Sale $sale)
    {
        $this->sale = $sale;
        $this->customer_id = $sale->customer_id;

        $this->loadProductsInCartIds();
        $this->getItemsToCart();
        $this->loadCart = true;
    }

    public function loadProductsInCartIds()
    {
        $this->productsInCartIds = \Cart::session(userId())->getContent()->pluck('id')->toArray();
    }

    public function isProductInCart($productId): bool
    {
        return in_array($productId, $this->productsInCartIds);
    }

    // Add Item on cart
    #[On('add-product')]
    public function addProduct(Product $product)
    {
        Cart::add($product);
        $this->loadProductsInCartIds();
    }

    #[On('quantityUpdated')]
    public function updateQuantity($productId, $newQuantity)
    {
        $newQuantity = intval($newQuantity);

        if ($newQuantity <= 0) {
            \Cart::session(userId())->remove($productId);
            return;
        }

        $cartItem = \Cart::session(userId())->get($productId);
        if (!$cartItem) {
            return;
        }

        \Cart::session(userId())->update($productId, [
            'quantity' => [
                'relative' => false,
                'value' => $newQuantity,
            ],
        ]);
        $this->loadProductsInCartIds();
    }

    // Decrement Item quantity on cart
    public function decrement($id)
    {
        Cart::decrement($id);
        $this->loadProductsInCartIds();
    }

    // Increment Item quantity on cart
    public function increment($id)
    {
        Cart::increment($id);
        $this->loadProductsInCartIds();
    }

    public function removeItem($id, $quantity)
    {
        Cart::removeItem($id);
        $this->loadProductsInCartIds();
    }

    public function getItemsToCart()
    {
        if ($this->loadCart) {
            return;
        }
        \Cart::session(userId())->clear();
        foreach ($this->sale->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
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
        $this->loadProductsInCartIds();
    }

    #[On('customerId')]
    public function customerId($id)
    {
        $this->customer_id = $id;
    }


    public function editSale()
    {
        $this->sale->total = Cart::getTotal();
        $this->sale->net_value = $this->sale->total;
        $this->sale->customer_id = $this->customer_id; // Atualiza o customer_id da venda

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
        $this->loadProductsInCartIds(); // Garante que a lista seja atualizada após a edição
    }

    #[Computed()]
    public function products()
    {
        return Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('sale_price', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'asc')
            ->paginate($this->registers);
    }
}