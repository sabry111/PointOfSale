@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Edit Order</h3>
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
                                                    class="{{ in_array($product->id, $order->products->pluck('id')->toArray()) ? 'btn btn-sm btn-default disabled' : 'btn btn-sm btn-success add-product-btn' }}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </td> --}}
                                            <td>
                                                <button
                                                    id="product-{{ $product->id }}"
                                                    class="{{ in_array($product->id, $order->products->pluck('id')->toArray()) ? 'btn btn-sm btn-default disabled' : 'btn btn-sm btn-success add-product-btn' }}"
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
                        <form
                            action="{{ route('dashboard.clients.orders.update', ['order' => $order->id, 'client' => $client->id]) }}"
                            method="post">
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

                                    @foreach ($order->products as $product)
                                        <tr>

                                            <td>{{ $product->name }}</td>
                                            <td><input type = 'number' name= 'product_ids[{{ $product->id }}][quantity]'
                                                    data-price='{{ $product->sale_price }}'
                                                    class='form-control product-quantity' min="1"
                                                    value="{{ $product->pivot->quantity }}">
                                            </td>
                                            <td class='product-price'>
                                                {{ number_format($product->sale_price * $product->pivot->quantity, 2) }}
                                            </td>
                                            <td> <button class='btn btn-danger remove-product-btn'
                                                    data-id='{{ $product->id }}'><i class='fa fa-trash'></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table><br>
                            <h4>Total : <span class="total-price">{{ number_format($order->total_price, 2) }}</span></h4>
                            <br>
                            <button class="btn btn-block btn-primary " id="edit-order-form-btn">Edit Order <i
                                    class='fa fa-edit'></i></button>
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
