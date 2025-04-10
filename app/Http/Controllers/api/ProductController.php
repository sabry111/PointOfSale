<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_update'])->only('update');
        $this->middleware(['permission:products_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(4);
        $products = ProductCollection::make($products);
        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Clients fetched Successfully.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $product =  Product::create($request_data);
        $product = ProductResource::make($product);
        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Clients Added Successfully.',
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
        // تحويل المنتج إلى Resource
        $productresource = ProductResource::make($product);
        // إرجاع استجابة JSON
        return response()->json([
            'success' => true,
            'data' => $productresource,
            'message' => 'Product updated successfully.',
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $old_name = $product->img;
        // حذف الصورة
        if ($old_name != 'default.png') {
            Storage::disk('public_uploads')->delete('products_image/' . $old_name);
        }
        // حذف المنتج 
        $product->delete();
        // إرجاع استجابة JSON تؤكد الحذف
        return response()->json([
            'data' => null,
            'message' => 'Product deleted successfully.',
            'error' => ''
        ], 200);
    }
}
