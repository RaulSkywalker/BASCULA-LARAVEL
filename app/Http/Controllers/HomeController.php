<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
    }


    public function index()
    {
        $data = Product::all();
        $cart = Cart::where('borrado', 0)->get()->map(function ($item) {
            $item['name'] = Product::find($item['product_id'])->name;
            return $item;
        });
        return view('home', ["products" => $data],["cart" => $cart]);
    }

    public function goToLogin(){
        return redirect()->route('auth.login');
    }
}
