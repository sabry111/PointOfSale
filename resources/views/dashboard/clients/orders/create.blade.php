@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Add Order</h3>
@endsection

@section('content')
    <div class="m-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories </h3>
                    </div>
                    <!-- /.card-header -->

                    @foreach ($categories as $category)
                        <a role="button" class="btn btn-info m-3" data-toggle="collapse"
                            data-target="#{{ str_replace(' ', '-', $category->name) }}">{{ $category->name }}</a>

                        <div id="{{ str_replace(' ', '-', $category->name) }}" class="collapse m-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Add</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($category->products as $product)
                                        <tr>
                                            <th>{{ $product->name }}</th>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ number_format($product->sale_price, 2) }}</td>
                                            {{-- <td><a id="product-{{ $product->id }}" data-name="{{ $product->name }}"
                                                    data-id="{{ $product->id }}" data-price="{{ $product->sale_price }}"
                                                    class="btn btn-sm btn-success add-product-btn">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td> --}}
                                            <td>
                                                <button
                                                    id="product-{{ $product->id }}"
                                                    class="btn btn-sm btn-success add-product-btn"
                                                    onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->sale_price }})">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    @endforeach



                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col (left) -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <form action="{{ route('dashboard.clients.orders.store', $client->id) }}" method="post">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="order-list">

                                </tbody>

                            </table><br>
                            <h4>Total : <span class="total-price">0</span></h4>
                            <br>
                            <button class="btn btn-block btn-primary disabled" id="add-order-form-btn">add order <i
                                    class='fa fa-plus'></i></button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col (right) -->
        </div>
    </div>
@endsection
