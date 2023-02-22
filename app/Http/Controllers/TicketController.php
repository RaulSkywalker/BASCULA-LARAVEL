<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\TicketItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TicketController extends Controller
{


    public function index()
    {
        $cart = Cart::where('borrado', 0)->get();
        $total = number_format($cart->sum('totalprice'), 2);
        $cart = $cart->map(function ($item) {
            $item['name'] = Product::find($item['product_id'])->name;
            return $item;
        });

        $ticket = new Ticket();
        $ticket->total = $total;
        $ticket->save();

        foreach ($cart as $item) {
            $ticketItem = new TicketItem();
            $ticketItem->ticket_id = $ticket->id;
            $ticketItem->product_id = $item['product_id'];
            $ticketItem->quantity = $item['weight'];
            $ticketItem->price = $item['totalprice'];
            $ticketItem->save();
        }

        Cart::where('borrado', 0)->update(['borrado' => 1]);

        return view('ticket', ["cart" => $cart, "total" => $total, "id_cliente" => $ticket->id]);


    }




    public function store(Request $request)
    {


        return view('invoice');
    }



    public function show($id)
    {


          return view('invoice');

    }


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
