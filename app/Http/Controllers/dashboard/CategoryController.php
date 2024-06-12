<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_update'])->only('edit');
        $this->middleware(['permission:categories_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(4);
        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');

    }

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        Category::create($request_data);
        return redirect(route('dashboard.categories.index'));

    }

    public function edit($id)
    {
        $categories = Category::findorfail($id);
        return view('dashboard.categories.edit', compact('categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request_data = $request->validate([
            'name' => 'required|unique:categories,name',
        ]);
        $category = Category::find($request->id);
        $category->update($request_data);
        return redirect(route('dashboard.categories.index'));
    }

    public function destroy($id)
    {

        $category = Category::findorfail($id);
        $category->delete();

        return redirect(route('dashboard.categories.index'));
    }
}
