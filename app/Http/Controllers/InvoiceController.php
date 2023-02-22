<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        $cart = Cart::where('borrado', 0)->get();
        $total = $cart->sum('totalprice');

        foreach ($cart as $item) {
            Invoice::create([
                'product_id' => $item->product_id,
                'totalprice' => $item->totalprice,
                'weight' => $item->weight,
            ]);

            $item->borrado = 1;
            $item->save();
        }

        return view('invoice', ["cart" => $cart, "total" => $total]);
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }
}
