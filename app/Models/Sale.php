<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot(['quantity']);
    }
    protected $dates = [
        'birth_date'
    ];

    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->attributes['status'] == 1 ? '<span class="badge badge-success" title="Concluído"> <i class="fas fa-check"></i></i> </span>' : '<span class="badge badge-danger" title="Pendente"><i class="fas fa-clock"></i></span>';
            }
        );
    }
}
