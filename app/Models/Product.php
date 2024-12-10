<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller(){
        return $this->belongsTo(Seller::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function estaDisponible()
    {
        return $this->estatus === Producto::PRODUCTO_DISPONIBLE;
    }

}
