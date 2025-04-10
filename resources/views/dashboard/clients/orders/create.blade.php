@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.add order')) }}</h3>
@endsection

@section('content')
    <div class="m-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ ucwords(__('site.categories')) }} </h3>
                    </div>
                    <!-- /.card-header -->

                    @foreach ($categories as $category)
                        <a role="button" class="btn btn-info m-3" data-toggle="collapse"
                            data-target="#{{ str_replace(' ', '-', $category->name) }}">{{ $category->name }}</a>

                        <div id="{{ str_replace(' ', '-', $category->name) }}" class="collapse m-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ ucwords(__('site.product name')) }}</th>
                                        <th scope="col">{{ ucwords(__('site.stock')) }}</th>
                                        <th scope="col">{{ ucwords(__('site.price')) }}</th>
                                        <th scope="col">{{ ucwords(__('site.add')) }}</th>
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
                                                <button id="product-{{ $product->id }}"
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
                        <h3 class="card-title">{{ ucwords(__('site.orders')) }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('dashboard.clients.orders.store', $client->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('post') }}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ ucwords(__('site.product name')) }}</th>
                                        <th scope="col">{{ ucwords(__('site.quantity')) }}</th>
                                        <th scope="col">{{ ucwords(__('site.price')) }}</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="order-list">

                                </tbody>
                            </table><br>
                            <h4>{{ ucwords(__('site.total')) }} : <span class="total-price">0</span></h4>
                            <br>
                            <button class="btn btn-block btn-info disabled"
                                id="add-order-form-btn">{{ ucwords(__('site.add order')) }} <i
                                    class='fa fa-plus'></i></button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                @if ($client->orders->count() > 0)
                    <div class="card">
                        <div class="card-header">

                            <h3 class="card-title" style="margin-bottom: 10px">{{ ucwords(__('site.previous orders')) }}
                                <small>{{ $orders->total() }}</small>
                            </h3>

                        </div><!-- end of box header -->

                        <div class="card-body">

                            @foreach ($orders as $order)
                                <div class="panel-group">

                                    <div class="panel panel-success">

                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-bs-toggle="collapse" aria-expanded="false"
                                                    aria-controls="{{ $order->id }}" role="button"
                                                    href="#{{ $order->id }}">{{ $order->created_at->toFormattedDateString() }}</a>
                                            </h4>
                                        </div>

                                        <div id="{{ $order->id }}" class="collapse">

                                            <div class="panel-body">

                                                <ul class="list-group">
                                                    @foreach ($order->products as $product)
                                                        <li class="list-group-item">
                                                            <div style="float: left"> {{ $product->name }} :
                                                                {{ $product->pivot->quantity }}</div>
                                                            <div style="float: right">{{ ucwords(__('site.total price')) }}
                                                                : {{ $order->total_price }}</div>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div><!-- end of panel body -->

                                        </div><!-- end of panel collapse -->

                                    </div><!-- end of panel primary -->

                                </div><!-- end of panel group -->
                            @endforeach

                            {{ $orders->links() }}

                        </div><!-- end of box body -->

                    </div><!-- end of box -->
                @endif
            </div>
            <!-- /.col (right) -->
        </div>
    </div>

@endsection
