@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Products Create </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">Create Product</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label>Product Descreption</label>
                    <textarea name="desc" class="form-control" placeholder="Enter Descreption">{{ old('desc') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Product Photo</label>
                    <input type="file" name="img" class="form-control">
                </div>
                <div class="form-group">
                    <label>Select Category</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Product Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock') }}"
                        placeholder="Enter Stock">
                </div>
                <div class="form-group">
                    <label>Product Purchase Price</label>
                    <input type="number" name="purchase_price" step="0.01" class="form-control" value="{{ old('purchase_price') }}"
                        placeholder="Enter Purchase Price">
                </div>
                <div class="form-group">
                    <label>Product Sale Price</label>
                    <input type="number" name="sale_price" step="0.01" class="form-control" value="{{ old('sale_price') }}"
                        placeholder="Enter Sale Price">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
@endsection
