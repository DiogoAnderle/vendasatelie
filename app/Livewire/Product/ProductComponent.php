<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Produtos')]
class ProductComponent extends Component
{
    //Trait
    use WithPagination;
    use WithFileUploads;
    //Propriedades de Classe
    public $search = '';
    public $totalRegistros = 0;
    public $quantity = 15;

    public $Id = 0;

    //Propriedades de Modelo
    public $productId = 0;
    public $name;
    public $category_id;
    public $description;
    public $purchase_price;
    public $sale_price;
    public $active = 1;
    public $image;
    public $imageModel;


    public function render()
    {
        $this->totalRegistros = Product::count();

        return view('livewire.product.product-component', ['products' => $this->products]);
    }

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    #[Computed()]
    public function products()
    {
        return Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('purchase_price', 'like', '%' . $this->search . '%')
            ->orWhere('sale_price', 'like', '%' . $this->search . '%')
            ->orWhere('active', 'like', '%' . $this->search == 'ativo' ? 1 : 0 . '%')
            ->orWhereHas('category', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            })->orderBy('id', 'asc')
            ->paginate($this->quantity);


    }

    public function create()
    {
        $this->Id = 0;
        $this->cleanFormFields();
        $this->dispatch('open-modal', 'modalProduct');
    }
    //Criar Produto
    public function store()
    {
        $rules = [
           // 'name' => 'required|min:3|max:255|unique:products',
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
            //'name' => ['required', 'min:3', 'max:255', Rule::unique('products')->ignore($this->Id)],
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
        $this->cleanFormFields();
    }

    #[On('destroyProduct')]
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image != null) {
            Storage::delete('public/' . $product->image->url);
            $product->image()->delete();
        }

        $product->delete();

        $this->dispatch('msg', 'Produto removido com sucesso.', 'success', '<i class="fas fa-check-circle"></i>');
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
