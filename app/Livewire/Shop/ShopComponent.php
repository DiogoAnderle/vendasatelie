<?php

namespace App\Livewire\Shop;

use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Shop')]
class ShopComponent extends Component
{
    use WithFileUploads;

    public $Id = 0;
    public $shop;
    public $name;
    public $cnpj;
    public $slogan;
    public $phone_number;
    public $email;
    public $address;
    public $city;
    public $image;
    public $imageModel;


    public function render()
    {
        return view('livewire.shop.shop-component');
    }
    public function mount()
    {
        $this->shop = Shop::first();
    }
    public function edit()
    {
        $this->Id = 1;
        $this->cleanFormFields();

        $this->name = $this->shop->name;
        $this->cnpj = $this->shop->cnpj;
        $this->slogan = $this->shop->slogan;
        $this->phone_number = $this->shop->phone_number;
        $this->email = $this->shop->email;
        $this->address = $this->shop->address;
        $this->city = $this->shop->city;

        $this->dispatch('open-modal', 'modalShop');

    }

    public function update()
    {
        $rules = [
            'name' => 'required|min:5|max:255',
            'cnpj' => 'max:255|nullable',
            'slogan' => 'max:255|nullable',
            'phone_number' => 'max:255|nullable',
            'email' => 'max:255|nullable|email',
            'address' => 'max:255|nullable',
            'city' => 'max:255|nullable',
            'image' => 'image|max:1024|nullable',
        ];

        $this->validate($rules);

        $this->shop->name = $this->name;
        $this->shop->cnpj = $this->cnpj;
        $this->shop->slogan = $this->slogan;
        $this->shop->phone_number = $this->phone_number;
        $this->shop->email = $this->email;
        $this->shop->address = $this->address;
        $this->shop->city = $this->city;

        $this->shop->update();

        if ($this->image) {
            if ($this->shop->image != null) {
                Storage::delete('public/' . $this->shop->image->url);
                $this->shop->image()->delete();
            }
            $customName = 'shop/' . uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('public', $customName);
            $this->shop->image()->create(['url' => $customName]);
        }

        $this->dispatch('close-modal', 'modalShop');
        $this->dispatch('msg', 'Dados atualizados com sucesso.');
        $this->cleanFormFields();
        $this->mount();

    }

    public function cleanFormFields()
    {
        $this->reset([
            'name',
            'cnpj',
            'slogan',
            'phone_number',
            'email',
            'address',
            'city',
            'image',
            'imageModel',
        ]);
        $this->resetErrorBag();

    }
}
