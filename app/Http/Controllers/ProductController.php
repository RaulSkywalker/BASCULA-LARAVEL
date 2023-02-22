<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoRequest;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("productos.crear");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGrupoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $producto= Product::create([
            "name" => $request->name,
            "price" => $request->price,
            'image'=> $request->image
        ]);



        return redirect("home");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        return view("editar", ["product" => Product::find($id)]);

    }



    public function edit(Product $product)
    {
        return view('editar', [
            "product" => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $product= Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        return redirect("home");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return redirect("home");
    }

    public function addToCart(Request $request)
    {
        $product= Product::find($request->id);

        $weight = $request->weight;
        $cartItem = Cart::where('product_id', $product->id)
            ->where('borrado', 0)
            ->first();
        if ($cartItem) {

            $cartItem->weight += $weight;
            $cartItem->totalprice += $product->price * $weight;
            $cartItem->save();
        } else {

            $totalPrice = $product->price * $weight;
            $cartItem = new Cart();
            $cartItem->product_id = $product->id;
            $cartItem->totalprice = $totalPrice;
            $cartItem->weight = $weight;
            $cartItem->borrado = 0;
            $cartItem->save();
        }

        return $this->populateItems();
    }
    public function removeCartItem(Request $request)
    {
        $cartItemId = $request->id;
        $cartItem = Cart::find($cartItemId);
        if ($cartItem) {
            $cartItem->borrado = 1;
            $cartItem->save();
        }

        return $this->populateItems();
    }


    public function populateItems(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $products = Product::all();
        $cartItems = Cart::where('borrado', 0)->get();
        $totalPrice = number_format($cartItems->sum('totalprice'), 2);

        $cartItems = $cartItems->map(function ($item) {
            $item->name = Product::find($item->product_id)->name;
            return $item;
        });
        return view('home', [
            "products" => $products,
            "cart" => $cartItems,
            "totalPrice" => $totalPrice
        ]);
    }

}
