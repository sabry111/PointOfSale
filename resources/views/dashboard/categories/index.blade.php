@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Categories</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">Categories</h1><br>

            <form action="{{ route('dashboard.categories.index') }}" method="get">
                <div class="mt-3 mb-3 float-left">

                    <input type="text" name="search" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" value="{{ request()->search }}">

                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">Serach</button>

                @if (auth()->user()->hasPermission('categories_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.categories.create') }}" role="button">Add</a>
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
                        <th>Category Name</th>
                        <th>Product Count</th>
                        <th>Related Product</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->products->count() }}</td>
                            <td><a class="btn btn-primary"
                                    href="{{ route('dashboard.products.index', ['category_id' => $category->id]) }}"
                                    role="button">Related Product</a></td>
                            <td>
                                @if (auth()->user()->hasPermission('categories_update'))
                                    <a class="btn btn-info" href="{{ route('dashboard.categories.edit', $category->id) }}"
                                        role="button">Edit</a>
                                @else
                                    <button class="btn btn-info disabled">Edit</button>
                                @endif
                                @if (auth()->user()->hasPermission('categories_delete'))
                                    <a class="btn btn-danger"
                                        href="{{ route('dashboard.categories.delete', $category->id) }}"
                                        role="button">Delete</a>
                                @else
                                    <button class="btn btn-danger disabled">Delete</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination mt-4">{{ $categories->appends(request()->query())->links() }}</div>
        </div>
        <!-- /.card-body -->

    </div>
@endsection
