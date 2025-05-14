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
    public $registers = 15;
    public $totalRegistros = 0;
    public array $productsInCartIds = [];

    // Payment Properties
    public $additionOrDiscount = 0;
    public $netValue = 0;
    public $updatingValue = 0;
    public $customerId = 1;
    public $customer = '';
    public $status = 0;
    public $invoice = 0;
    public $order_notes;
    public $quantities = [];

    protected $listeners = ['product-updated' => 'refresh'];

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
                'total' => Cart::getTotal() + floatval($this->additionOrDiscount),
                'totalItems' => Cart::totalItems(),
            ]
        );
    }

    public function mount()
    {
        $this->loadProductsInCartIds();
    }

    public function loadProductsInCartIds()
    {
        $this->productsInCartIds = \Cart::session(userId())->getContent()->pluck('id')->toArray();
    }

    public function isProductInCart($productId): bool
    {
        return in_array($productId, $this->productsInCartIds);
    }

    #[On('add-product')]
    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            \Cart::session(userId())->add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
                'attributes' => [],
                'associatedModel' => $product,
            ]);
            $this->quantities[$product->id] = 1;
            $this->updatingValue = 0;
            $this->loadProductsInCartIds(); // Atualiza a lista imediatamente
        }
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
        if (!$cartItem) {
            return;
        }

        // Atualiza a quantidade no carrinho
        \Cart::session(userId())->update($productId, [
            'quantity' => [
                'relative' => false,
                'value' => $newQuantity,
            ],
        ]);

        $this->updatingValue = 0; // Força atualização de valores
        $this->loadProductsInCartIds(); // Atualiza a lista após alterar a quantidade
    }

    #[On('customerId')]
    public function customerId($id = 1)
    {
        $this->customerId = $id;
    }

    //Remove Item on cart
    public function removeItem($id, $quantity)
    {
        Cart::removeItem($id);
        $this->loadProductsInCartIds(); // Atualiza a lista imediatamente
    }

    //Clean Cart
    public function clear()
    {
        Cart::clear();

        $this->netValue = 0;
        $this->additionOrDiscount = 0;
        $this->dispatch('msg', 'Venda cancelada com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');
        $this->dispatch('refreshProducts');
        $this->loadProductsInCartIds(); // Atualiza a lista imediatamente
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
            $sale->invoice = $this->invoice;
            $sale->order_notes = $this->order_notes;
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
                    "date_item_sale" => date('Y-m-d'),
                ]);
            }

            Cart::clear();
            $this->reset(['additionOrDiscount', 'netValue', 'customer', 'order_notes']);
            $this->status = false;
            $this->invoice = false;
            $this->dispatch('msg', 'Venda criada com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');
            $this->loadProductsInCartIds(); // Garante que a lista esteja vazia após a venda
        });
    }

    public function updatingNetValue($value)
    {
        $this->updatingValue = 1;
        $this->netValue = Cart::getTotal();
        $this->netValue = $value + floatval($this->additionOrDiscount);
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

    public function editProduct(int $productId)
    {
        $this->dispatch('open-product-modal', $productId);
    }

}