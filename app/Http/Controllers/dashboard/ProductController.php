<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_create'])->only('create');
        $this->middleware(['permission:products_update'])->only('edit','update');
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
        // dd($request);
        $request_data = $request->validate([
            'name' => 'required|string|max:50',
            'desc' => 'required|string',
            'stock' => 'required|integer',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'category_id' => 'required|exists:categories,id',
            'img' => 'image|mimes:png,jpg,jpeg',
        ]);

        if ($request->hasFile('img') && $request->file('img')->isValid()) {
            $file = $request->file('img');
            $path = public_path('uploads/products_image/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $new_name = $file->hashName();
            $file->move($path, $new_name);
            $image = Image::make($path . $new_name);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save();
            $request_data['img'] = $new_name;
        }
        Product::create($request_data);
        return redirect(route('dashboard.products.index'));
    }

    public function edit(Product $product)
    {

        $categories = Category::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
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
        $old_name = $product->img;
        if ($request->hasFile('img')) {
            if ($old_name != 'default.png') {
                Storage::disk('public_uploads')->delete('products_image/' . $old_name);
            }
            $file = $request->file('img');
            $path = public_path('uploads/products_image/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $new_name = $file->hashName();
            $file->move($path, $new_name);
            $image = Image::make($path . $new_name);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save();
            $request_data['img'] = $new_name;
        } else {

            $request_data['img'] = $old_name;
        }

        $product->update($request_data);
        return redirect(route('dashboard.products.index'));
    }

    public function destroy(Product $product)
    {
        $old_name = $product->img;
        if ($old_name != 'default.png') {
            Storage::disk('public_uploads')->delete('products_image/' . $old_name);
        }
        $product->delete();
        return redirect(route('dashboard.products.index'));
    }
}
