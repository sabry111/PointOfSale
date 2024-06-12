<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_create'])->only('create');
        $this->middleware(['permission:products_update'])->only('edit');
        $this->middleware(['permission:products_delete'])->only('destroy');

    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(4);
        return view('dashboard.products.index', compact('categories', 'products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));

    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'name' => 'required|string|max:50',
            'desc' => 'required|string',
            'stock' => 'required|integer',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'category_id' => 'required|exists:categories,id',
            'img' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($request->img) {
            $new_name = $request->img->hashName();
            Image::make($request->img)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_image/' . $new_name));

            $request_data['img'] = $new_name;
        }

        Product::create($request_data);
        return redirect(route('dashboard.products.index'));
    }

    public function edit(Product $product, $id)
    {

        $categories = Category::all();
        $products = Product::findorfail($id);
        return view('dashboard.products.edit', compact('products', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request_data = $request->validate([
            'name' => 'required|string|max:50',
            'desc' => 'required|string',
            'stock' => 'required|integer',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'category_id' => 'required|exists:categories,id',
            'img' => 'image|mimes:png,jpg,jpeg',
        ]);
        $old_name = Product::findorfail($request->id)->img;

        if ($request->hasFile('img')) {
            if ($old_name != 'default.png') {
                Storage::disk('public_uploads')->delete('products_image/' . $old_name);
            }
            $new_name = $request->img->hashName();
            Image::make($request->img)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_image/' . $new_name));
            $request_data['img'] = $new_name;

        } else {

            $request_data['img'] = $old_name;

        }

        $product = Product::find($request->id);
        $product->update($request_data);
        return redirect(route('dashboard.products.index'));

    }

    public function destroy(Product $product, $id)
    {
        $product = Product::find($id);
        $old_name = $product->img;

        if ($old_name != 'default.png') {
            Storage::disk('public_uploads')->delete('products_image/' . $old_name);
        }

        $product = product::findorfail($id);
        $product->delete();

        return redirect(route('dashboard.products.index'));
    }
}
