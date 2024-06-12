@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Products</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">Products</h1><br>

            <form action="{{ route('dashboard.products.index') }}" method="get">
                <div class="m-3 float-left">

                    <input type="text" name="search" class="form-control" value="{{ request()->search }}">

                </div>
                <div class="m-3 float-left">

                    <select name="category_id" class="form-control">
                        <option value="">all categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">Serach</button>

                @if (auth()->user()->hasPermission('products_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.products.create') }}" role="button">Add</a>
                @else
                    <button class="btn btn-primary disabled">Add</button>
                @endif

            </form>


        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Desc</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Perchase Price</th>
                        <th>Sale Price</th>
                        <th>Gain %</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{!! $product->desc !!}</td>
                            <td><img src="{{ asset('uploads/products_image/' . $product->img) }}" width="80px"
                                    class="img-thumbnail" alt="no photo"></td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->purchase_price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>{{ $product->profit_percent }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if (auth()->user()->hasPermission('products_update'))
                                    <a class="btn btn-info" href="{{ route('dashboard.products.edit', $product->id) }}"
                                        role="button">Edit</a>
                                @else
                                    <button class="btn btn-info disabled">Edit</button>
                                @endif
                                @if (auth()->user()->hasPermission('products_delete'))
                                    <a class="btn btn-danger" href="{{ route('dashboard.products.delete', $product->id) }}"
                                        role="button">Delete</a>
                                @else
                                    <button class="btn btn-danger disabled">Delete</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination mt-4">{{ $products->appends(request()->query())->links() }}</div>
        </div>
        <!-- /.card-body -->

    </div>
@endsection
