<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected function activeLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->attributes['active'] == 1 ? '<span class="badge badge-success"> Ativo </span>' : '<span class="badge badge-danger">Inativo</span>';
            }
        );
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }


    protected function imagem(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->image ? Storage::url('public/' . $this->image->url) : asset('no-image.png');
            }
        );
    }

    //Relations

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
