<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Categorias')]
class CategoryComponent extends Component
{
    //Trait
    use WithPagination;
    //Propriedades de Classe
    public $search = '';
    public $totalRegistros = 0;
    public $quantity = 10;

    //Propriedades de Modelo
    public $name;
    public $Id;



    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }
        $this->totalRegistros = Category::count();

        $categories = Category::where('name', 'like', '%' . $this->search . '%')->orWhere('id', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->quantity);
        //$categories = collect();
        return view('livewire.category.category-component', compact('categories'));
    }
    public function mount()
    {

    }
    public function create()
    {
        $this->Id = 0;
        $this->reset(['name']);
        $this->resetErrorBag();
        $this->dispatch('open-modal', 'modalCategory');
    }

    //Criar categoria
    public function store()
    {
        // dump('Criar Categoria');
        $rules = [
            'name' => 'required|min:3|max:255|unique:categories'

        ];
        $messages = [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve conter no mímino 3 caracteres',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',
            'name.unique' => 'O nome da categoria já está em uso',
        ];

        $this->validate($rules, $messages);

        $category = new Category();
        $category->name = $this->name;
        $category->save();

        $this->dispatch('close-modal', 'modalCategory');
        $this->dispatch('msg', 'Categoria criada com sucesso.');
        $this->reset(['name']);
    }

    public function edit(Category $category)
    {
        $this->Id = $category->id;
        $this->name = $category->name;
        $this->dispatch('open-modal', 'modalCategory');
        $this->resetErrorBag();
    }

    public function update(Category $category)
    {
        $rules = [
            'name' => ['required', 'min:3', 'max:255', Rule::unique('categories')->ignore($this->Id)]
        ];
        $messages = [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve conter no mímino 3 caracteres',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',
            'name.unique' => 'O nome da categoria já está em uso',
        ];
        $this->validate($rules, $messages);

        $category->name = $this->name;
        $category->update();

        $this->dispatch('close-modal', 'modalCategory');
        $this->dispatch('msg', 'Categoria editada com sucesso.');
        $this->reset(['name']);
    }

    #[On('destroyCategory')]
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        $this->dispatch('msg', 'Categoria removida com sucesso.');
    }
}
