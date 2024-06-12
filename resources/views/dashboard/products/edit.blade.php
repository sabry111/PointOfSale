@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Products Edit </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">

        <!-- form start -->
        <form method="POST" action="{{ route('dashboard.products.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $products->id }}">
                <div class="form-group">
                    <label>Proudect Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $products->name }}">
                </div>
                <div class="form-group">
                    <label>Product Descreption</label>
                    <textarea name="desc" class="form-control">{{ $products->desc }}</textarea>
                </div>
                <div class="form-group">
                    <label>Product Photo</label>
                    <input type="file" name="img" class="form-control">
                </div>
                <div class="form-group">
                    <label>Select Category</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $products->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Product Stock</label>
                    <input type="text" name="stock" class="form-control" value="{{ $products->stock }}">
                </div>
                <div class="form-group">
                    <label>Product Purchase Price</label>
                    <input type="text" name="purchase_price" step="0.01" class="form-control"
                        value="{{ $products->purchase_price }}">
                </div>
                <div class="form-group">
                    <label>Product Sale Price</label>
                    <input type="text" name="sale_price" step="0.01" class="form-control"
                        value="{{ $products->sale_price }}">
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </div>
@endsection
