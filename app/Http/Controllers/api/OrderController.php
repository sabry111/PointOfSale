<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'products_id' => 'required|array',
        ]);
        $this->attach_order($request, $client);
        $latest_order = Order::latest()->with('client')->first();
        $order = OrderResource::make($latest_order);
        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Orders Maked Successfully.',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client, Order $order)
    {
        $request->validate([
            'products_id' => 'required|array',
        ]);
        $this->detach_order($order);
        $this->attach_order($request, $client);
        $latest_order = Order::latest()->with('client')->first();
        $new_order = OrderResource::make($latest_order);
        return response()->json([
            'success' => true,
            'data' => $new_order,
            'message' => 'Orders Updated Successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    private function attach_order(Request $request, Client $client)
    {
        $order = $client->orders()->create([]);
        $order->products()->attach($request->products_id);
        $total_price = 0;
        foreach ($request->products_id as $id => $quantity) {
            $product = Product::findorfail($id);
            $total_price += $product->sale_price * $quantity['quantity'];
            $product->update([
                'stock' => $product->stock - $quantity['quantity'],
            ]);
        }
        $order->update([
            'total_price' => $total_price,
        ]);
    } // end of attach to create order

    private function detach_order(Order $order)
    {
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }
        $order->delete();
    } //end of delete order
}
