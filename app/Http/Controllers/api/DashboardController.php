<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $users_count = User::whereHasRole('admin')->count();
        $categories_count = Category::count();
        $products_count = Product::count();
        $clients_count = Client::count();
        return response()->json(['data' => ['user_count' => $users_count, 'categories_count' => $categories_count, 'products_count' => $products_count, 'clients_count' => $clients_count], 'error' => ''], 200);
    }
}
