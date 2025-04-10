<?php

namespace App\Http\Controllers\dashboard\clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        //
    }

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        $orders = $client->orders()->with('products')->paginate(5);
        return view('dashboard.clients.orders.create', compact('client', 'categories', 'orders'));
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'products_id' => 'required|array',
        ]);
        $this->attach_order($request, $client);
        return redirect(route('dashboard.orders.index'));
    }

    public function show()
    {
        //
    }

    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.edit', compact('order', 'client', 'categories'));
    }

    public function update(Request $request, Client $client, Order $order)
    {
        $request->validate([
            'products_id' => 'required|array',

        ]);

        $this->detach_order($order);

        $this->attach_order($request, $client);

        return redirect(route('dashboard.orders.index'));
    }

    public function destroy(Order $order)
    {
        //
    }

    // attach to create order
    private function attach_order(Request $request, Client $client)
    {
        // dd($request->products_id);
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

    // // delete order
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
