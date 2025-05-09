<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductSale extends Component
{
    public $Id;
    public $name;
    public $description;
    public $sale_price;
    public $stock_quantity;
    public $imagem; // Se você tiver um campo para imagem

    public $modalProduct = false;

    protected $listeners = ['resetForm'];

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'nullable',
        'sale_price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'imagem' => 'nullable|image|max:2048', // Exemplo de validação de imagem
    ];

    public function render()
    {
        return view('livewire.product.product-sale');
    }

    public function openModal()
    {
        $this->modalProduct = true;
    }

    public function closeModal()
    {
        $this->modalProduct = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'sale_price', 'stock_quantity', 'imagem', 'Id']);
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate();

        $product = new Product();
        $product->name = $this->name;
        $product->description = $this->description;
        $product->sale_price = $this->sale_price;
        $product->stock_quantity = $this->stock_quantity;
        // Lógica para salvar a imagem, se necessário
        $product->save();

        $this->closeModal();
        $this->dispatch('msg', 'Produto cadastrado com sucesso!', 'success');
        $this->dispatch('refreshProducts'); // Se você precisar atualizar a lista de produtos
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->Id = $product->id;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->sale_price = $product->sale_price;
            $this->stock_quantity = $product->stock_quantity;
            $this->imagem = $product->imagem;
            $this->openModal();
        }
    }

    public function update($id)
    {
        $this->validate();

        $product = Product::find($id);
        if ($product) {
            $product->name = $this->name;
            $product->description = $this->description;
            $product->sale_price = $this->sale_price;
            $product->stock_quantity = $this->stock_quantity;
            // Lógica para atualizar a imagem, se necessário
            $product->save();

            $this->closeModal();
            $this->dispatch('msg', 'Produto atualizado com sucesso!', 'success');
            $this->dispatch('refreshProducts');
        }
    }
}