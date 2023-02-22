<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=[
        'id',
        'borrado',
        'totalprice',
        'weight'

    ];


    use HasFactory;
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'cart_invoice');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
