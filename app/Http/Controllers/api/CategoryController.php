<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_update'])->only('update');
        $this->middleware(['permission:categories_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(4);

        $categories = CategoryCollection::make($categories);
        return response()->json([
            'success' => true,
            'data' => $categories,
            'message' => 'Clients fetched successfully.',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request_data = $request->validate([
            'name' => 'required|unique:categories,name',
        ]);
        $category = Category::create($request_data);
        $category = CategoryResource::make($category);
        return response()->json([
            'success' => true,
            'data' => $category,
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
    public function update(Request $request, Category $category)
    {
        $request_data = $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);
        $category->update($request_data);
        $category = CategoryResource::make($category);
        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Clients Updated Successfully.',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category Deleted Successfully.',
        ], 200);
    }
}
