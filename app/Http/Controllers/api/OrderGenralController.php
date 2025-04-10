<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewProductCollection;
use App\Http\Resources\NewProductResource;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderGenralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::whereHas('client', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);
        $orders = OrderCollection::make($orders);
        return response()->json([
            'success' => true,
            'data' => $orders,
            'message' => 'Orders fetched Successfully.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Client $client)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {

        $products = $order->products()->get();
        $products = NewProductCollection::make($products);
        return response()->json([
            'success' => true,
            'data' => ['data' => $products, 'total_price' => $order->total_price],
            'message' => 'Products fetched Successfully.',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity,
            ]);
        }
        $order->delete();
        return response()->json([
            'data' => null,
            'message' => 'Order deleted successfully.',
            'error' => ''
        ], 200);
    }
}
