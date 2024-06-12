@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Add Order</h3>
@endsection

@section('content')
    <div class="m-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders </h3><br>
                        <form action="{{ route('dashboard.orders.index') }}" method="get">
                            <div class="mt-3 mb-3 float-left">

                                <input type="text" name="search" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" value="{{ request()->search }}">

                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3 mb-3 ml-3">Serach <i
                                    class='fa fa-search'></i></button>
                        </form>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>

                                        <td>{{ $order->client->name }}</td>
                                        <td>{{ number_format($order->total_price, 2) }}</td>
                                        <td>{{ $order->created_at->toFormattedDateString() }}</td>


                                        <td>
                                            <a class="btn btn-primary btn-sm order-products " role="button"
                                                data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                                data-method="get">Show <i class='fa fa-list'></i></a>
                                            @if (auth()->user()->hasPermission('orders_update'))
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('dashboard.clients.orders.edit', ['client' => $order->client->id, 'order' => $order->id]) }}"
                                                    role="button">Edit <i class='fa fa-edit'></i></a>
                                            @else
                                                <button class="btn btn-warning disabled btn-sm">Edit<i
                                                        class='fa fa-edit'></i></button>
                                            @endif
                                            @if (auth()->user()->hasPermission('orders_delete'))
                                                <a class="btn btn-danger btn-sm"
                                                    href="{{ route('dashboard.orders.delete', $order->id) }}"
                                                    role="button">Delete<i class='fa fa-trash'></i></a>
                                            @else
                                                <button class="btn btn-danger disabled btn-sm">Delete<i
                                                        class='fa fa-trash'></i></button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>




                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col (left) -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders View</h3>
                    </div><br>
                    <!-- /.card-header -->
                    <div style="display: none; flex-direction: column; align-items: center" id="loading">
                        <div class="loader"></div>
                        <div class="spinner-border text-info" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>loading</p>
                    </div>
                    <div class="card-body">
                        <div id="order-product-list">

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col (right) -->
        </div>
        <div class="pagination mt-4">{{ $orders->appends(request()->query())->links() }}</div>
    </div>
@endsection
