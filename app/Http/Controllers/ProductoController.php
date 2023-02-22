<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoRequest;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductoController extends Controller
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


    public function show($id)
    {

        return view("productos.mostrar", ["producto" => Product::find($id)]);

    }


    public function edit($id)
    {
        //
        $producto = Product::find($id);
        return view("productos.editar",["producto" => $producto]);
    }


    public function update(Request $request, $id)
    {
        //
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
        $cart = Cart::find($id);
        $cart->borrado = 1;
        $cart->save();;
        return redirect("home");
    }
    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $price = $product->price;
        $weight = $request->weight;
        $totalPrice = $price * $weight;


        $existingCart = Cart::where([
            ['product_id', '=', $product->id],
            ['borrado', '=', 0]
        ])->first();

        if ($existingCart) {

            $existingCart->weight += $weight;
            $existingCart->totalprice += $totalPrice;
            $existingCart->save();
        } else {

            $cart = Cart::create([
                'product_id' => $product->id,
                'totalprice' => $totalPrice,
                'weight' => $weight
            ]);
        }

        $data = Product::all();

        $cart = Cart::where('borrado', 0)->get()->map(function ($item) {
            $item['nombre'] = Product::find($item['product_id'])->name;
            return $item;
        });
        $total=+$totalPrice;
        return view('home', ["products" => $data], ["cart" => $cart], ["total" => $total]);
    }

}
