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

    // Payment Properties
    public $additionOrDiscount = 0;
    public $netValue = 0;
    public $updatingValue = 0;

    public $status = 0;
    public $invoice = 0;
    public $order_notes;

    public array $productsInCartIds = [];

    public Sale $sale;
    public $customer_id; // Para armazenar o ID do cliente selecionado
    public $loadCart = false;

    public function render()
    {
        $this->totalRegistros = Product::count();

        if ($this->updatingValue == 0) {
            $this->netValue = Cart::getTotal();
            $this->netValue = Cart::getTotal() + floatval($this->additionOrDiscount);
        }

        return view('livewire.sale.sale-edit', [
            'products' => $this->products,
            'cart' => Cart::getCart(),
            'totalItems' => Cart::totalItems(),
            'total' => Cart::getTotal() + floatval($this->additionOrDiscount),
        ]);
    }

    public function mount(Sale $sale)
    {
        $this->sale = $sale;
        $this->customer_id = $sale->customer_id;

        $this->status = $sale->status;
        $this->invoice = $sale->invoice;
        $this->order_notes = $sale->order_notes;
        $this->total = $sale->net_value;
        $this->netValue = $sale->net_value ?? 0; // Se for null, usa 0
        $this->additionOrDiscount = $sale->addition_discount ?? 0; // Se for null, usa 0


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
        $cart = Cart::getCart();
        if (count($cart) == 0) {
            $this->dispatch('msg', 'Venda não pode ser editada, carrinho vazio!', 'danger', '<i class="fas fa-exclamation-triangle"></i>');
            return;
        }

        $this->sale->total = Cart::getTotal();
        $this->sale->net_value = $this->netValue;
        $this->sale->customer_id = $this->customer_id; // Atualiza o customer_id da venda
        $this->sale->status = $this->status;
        $this->sale->invoice = $this->invoice;
        $this->sale->order_notes = $this->order_notes;
        $this->sale->addition_discount = $this->additionOrDiscount;

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