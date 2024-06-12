<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
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

        return view('dashboard.index', compact('users_count', 'categories_count', 'products_count', 'clients_count'));
    }
}
