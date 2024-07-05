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
use Livewire\WithFileUploads;

#[Title('Ver Produto')]
class ProductShow extends Component
{
    //Trait
    use WithFileUploads;

    //Propriedades de Modelo
    public $Id = 0;
    public $name;
    public $category_id;
    public $description;
    public $purchase_price;
    public $sale_price;
    public $stock = 0;
    public $min_stock = 5;
    public $active = 1;
    public $image;
    public $imageModel;
    public Product $product;
    public function render()
    {
        return view('livewire.product.product-show');
    }
    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    public function edit(Product $product)
    {
        $this->cleanFormFields();

        $this->Id = $product->id;
        $this->name = $product->name;
        $this->category_id = $product->category_id;
        $this->description = $product->description;
        $this->purchase_price = $product->purchase_price;
        $this->sale_price = $product->sale_price;
        $this->stock = $product->stock;
        $this->min_stock = $product->min_stock;
        $this->active = $product->active;
        $this->imagemModel = $product->image;

        $this->dispatch('open-modal', 'modalProduct');

        //dump($product);
    }
    public function update(Product $product)
    {
        // dump($product);
        $rules = [
            'name' => ['required', 'min:3', 'max:255', Rule::unique('products')->ignore($this->Id)],
            'description' => 'max:255',
            'purchase_price' => 'numeric|nullable',
            'sale_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'min_stock' => 'numeric|nullable',
            'image' => 'max:1024|nullable',
            'category_id' => 'required|numeric',
        ];

        $this->validate($rules);

        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->description = $this->description;
        $product->purchase_price = $this->purchase_price;
        $product->sale_price = $this->sale_price;
        $product->stock = $this->stock;
        $product->min_stock = $this->min_stock;
        $product->active = $this->active;
        //$product->image; = $this->imagemModel

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
        $this->dispatch('msg', 'Produto editado com sucesso.','success', '<i class="fas fa-check-circle"></i>');
        $this->dispatch('edited');
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

        return redirect()->to('/produtos')->with(['msg'=>'Produto removido com sucesso.','type'=>'success','icon'=>'<i class="fas fa-check-circle"></i>']);
    }

    public function cleanFormFields()
    {
        $this->reset([
            'Id',
            'name',
            'image',
            'description',
            'purchase_price',
            'sale_price',
            'stock',
            'min_stock',
            'active',
            'category_id'
        ]);
        $this->resetErrorBag();
    }

    #[On('edited')]
    public function refresh()
    {
    }
}
