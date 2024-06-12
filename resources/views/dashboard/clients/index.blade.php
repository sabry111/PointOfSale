@extends('layouts.dashboard.master')


@section('title_page')
    <h3>
        Clients</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">Clients</h1><br>

            <form action="{{ route('dashboard.clients.index') }}" method="get">
                <div class="mt-3 mb-3 float-left">

                    <input type="text" name="search" class="form-control" value="{{ request()->search }}">

                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">Serach</button>

                @if (auth()->user()->hasPermission('clients_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.clients.create') }}" role="button">Add</a>
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
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Add Order</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ implode(' / ', $client->phone) }}</td>
                            <td>{{ $client->address }}</td>
                            <td>
                                @if (auth()->user()->hasPermission('orders_create'))
                                    <a class="btn btn-info"
                                        href="{{ route('dashboard.clients.orders.create', $client->id) }}"
                                        role="button">Add
                                        Order</a>
                                @else
                                    <button class="btn btn-info disabled">Add Order</button>
                                @endif
                            </td>

                            <td>
                                @if (auth()->user()->hasPermission('clients_update'))
                                    <a class="btn btn-info" href="{{ route('dashboard.clients.edit', $client->id) }}"
                                        role="button">Edit</a>
                                @else
                                    <button class="btn btn-info disabled">Edit</button>
                                @endif
                                @if (auth()->user()->hasPermission('clients_delete'))
                                    <a class="btn btn-danger" href="{{ route('dashboard.clients.delete', $client->id) }}"
                                        role="button">Delete</a>
                                @else
                                    <button class="btn btn-danger disabled">Delete</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination mt-4">{{ $clients->appends(request()->query())->links() }}</div>
        </div>
        <!-- /.card-body -->

    </div>
@endsection
