<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=[
        'id',
        'finalprice',

    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_invoice');
    }
}
