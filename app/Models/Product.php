<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{

    use HasFactory;

    //Relação Polifórmica Imagem
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //Atributos
    protected function stockLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->attributes['stock'] >= $this->attributes['min_stock'] ? '<span class="badge badge-pill  badge-success">' . $this->attributes['stock'] . '</span>' : '<span class="badge badge-pill badge-danger">' . $this->attributes['stock'] . '</span>';
            }
        );
    }

    protected function activeLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->attributes['active'] == 1 ? '<span class="badge badge-success"> Ativo </span>' : '<span class="badge badge-danger">Inativo</span>';
            }
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function () {
                return "<b>R$" . number_format($this->attributes['sale_price'], 2, ',', '.') . "<b>";
            }
        );
    }
    protected function imagem(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->image ? Storage::url('public/' . $this->image->url) : asset('no-image.png');
            }
        );
    }
}
