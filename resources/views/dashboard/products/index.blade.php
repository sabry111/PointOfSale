@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.products')) }}</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">{{ ucwords(__('site.products')) }}</h1><br>

            <form action="{{ route('dashboard.products.index') }}" method="get">
                <div class="m-3 float-left">

                    <input type="text" name="search" class="form-control" placeholder="{{ ucwords(__('site.search')) }}"
                        value="{{ request()->search }}">

                </div>
                <div class="m-3 float-left">

                    <select name="category_id" class="form-control">
                        <option value="">{{ ucwords(__('site.all categories')) }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request()->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">{{ ucwords(__('site.search')) }}</button>

                @if (auth()->user()->hasPermission('products_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.products.create') }}"
                        role="button">{{ ucwords(__('site.add')) }}</a>
                @else
                    <button class="btn btn-primary disabled">{{ ucwords(__('site.add')) }}</button>
                @endif

            </form>


        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if ($products->count() > 0)
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>{{ ucwords(__('site.product name')) }}</th>
                            <th>{{ ucwords(__('site.desc')) }}</th>
                            <th>{{ ucwords(__('site.photo')) }}</th>
                            <th>{{ ucwords(__('site.category')) }}</th>
                            <th>{{ ucwords(__('site.purchase price')) }}</th>
                            <th>{{ ucwords(__('site.sale price')) }}</th>
                            <th>{{ ucwords(__('site.gain %')) }}</th>
                            <th>{{ ucwords(__('site.stock')) }}</th>
                            <th>{{ ucwords(__('site.action')) }}</th>
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
                                <td>{{ $product->profit_percent }} %</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if (auth()->user()->hasPermission('products_update'))
                                        <a class="btn btn-info" href="{{ route('dashboard.products.edit', $product->id) }}"
                                            role="button">{{ ucwords(__('site.edit')) }}</a>
                                    @else
                                        <button class="btn btn-info disabled">{{ ucwords(__('site.edit')) }}</button>
                                    @endif
                                    @if (auth()->user()->hasPermission('products_delete'))
                                        <form action="{{ route('dashboard.products.destroy', $product->id) }}"
                                            method="POST" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit"
                                                class="btn btn-danger">{{ ucfirst(__('site.delete')) }}</button>
                                        </form>
                                    @else
                                        <button class="btn btn-danger disabled">{{ ucwords(__('site.delete')) }}</button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-4">{{ $products->appends(request()->query())->links() }}</div>
            @else
                <h2>{{ ucwords(__('site.no data found')) }}</h2>
            @endif
        </div>
        <!-- /.card-body -->

    </div>
@endsection
