<?php

namespace App\Livewire\Sale;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductSale extends Component
{
    use WithFileUploads;
    public $productId;

    public $name;
    public $category_id;
    public $description;
    public $purchase_price;
    public $sale_price;
    public $active = 1;
    public $image;
    public $imageModel;

    protected $listeners = ['open-product-modal' => 'edit'];

    public function render()
    {
        return view('livewire.sale.product-sale');
    }

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    public function openModal(): void
    {
        $this->dispatch(event: 'open-modal', params: 'modalProduct');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:3|max:255|unique:products',
            'description' => 'max:255',
            'purchase_price' => 'numeric|nullable',
            'sale_price' => 'required|numeric',
            'image' => 'max:1024|nullable',
            'category_id' => 'required|numeric',

        ];
        $messages = [
            'purchase_price.numeric' => 'O campo preço de compra deve ser numérico.',
            'sale_price.required' => 'O campo preço de venda é obrigatório.',
            'sale_price.numeric' => 'O campo preço de venda deve ser numérico.',
            'category_id.required' => 'Selecione uma categoria.',
        ];

        $this->validate($rules, $messages);

        $product = new Product();

        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->description = $this->description;
        $product->purchase_price = $this->purchase_price;
        $product->sale_price = $this->sale_price;
        $product->active = $this->active;

        $product->save();

        if ($this->image) {
            $customName = 'products/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $product->image()->create(['url' => $customName]);
        }

        $this->dispatch('close-modal', 'modalProduct');
        $this->dispatch('msg', 'Produto criado com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');
        $this->cleanFormFields();
    }

    public function edit(Product $product)
    {
        $this->cleanFormFields();

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->purchase_price = $product->purchase_price;
        $this->sale_price = $product->sale_price;
        $this->active = $product->active;
        $this->imagemModel = $product->image;

        $this->dispatch('open-modal', 'modalProduct');
    }

    public function update(Product $product)
    {
        $rules = [
            'name' => ['required', 'min:3', 'max:255', Rule::unique('products')->ignore($this->productId)],
            'description' => 'max:255',
            'purchase_price' => 'numeric|nullable',
            'sale_price' => 'required|numeric',
            'image' => 'max:1024|nullable',
            'category_id' => 'required|numeric',
        ];

        $this->validate($rules);

        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->description = $this->description;
        $product->purchase_price = $this->purchase_price;
        $product->sale_price = $this->sale_price;
        $product->active = $this->active;

        $product->update();

        if ($this->image) {
            if ($product->image != null) {
                Storage::delete('public/' . $product->image->url);
                $product->image()->delete();
            }
            $customName = 'products/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $product->image()->create(['url' => $customName]);
        }

        $this->dispatch('close-modal', 'modalProduct');
        $this->dispatch('msg', 'Produto editado com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');
        $this->dispatch('product-updated', $product->id);
        $this->cleanFormFields();
    }

    public function cleanFormFields()
    {
        $this->reset([
            'productId',
            'name',
            'image',
            'description',
            'purchase_price',
            'sale_price',
            'active',
            'category_id'
        ]);
        $this->resetErrorBag();
    }

}
