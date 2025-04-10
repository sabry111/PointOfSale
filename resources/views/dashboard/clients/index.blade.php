@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.clients')) }}</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">{{ ucwords(__('site.clients')) }}</h1><br>

            <form action="{{ route('dashboard.clients.index') }}" method="get">
                <div class="mt-3 mb-3 float-left">

                    <input type="text" placeholder="{{ ucwords(__('site.search')) }}" name="search" class="form-control" value="{{ request()->search }}">

                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">{{ ucwords(__('site.search')) }}</button>

                @if (auth()->user()->hasPermission('clients_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.clients.create') }}"
                        role="button">{{ ucwords(__('site.add')) }}</a>
                @else
                    <button class="btn btn-primary disabled">{{ ucwords(__('site.add')) }}</button>
                @endif

            </form>


        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if ($clients->count() > 0)
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>{{ ucwords(__('site.client name')) }}</th>
                            <th>{{ ucwords(__('site.phone')) }}</th>
                            <th>{{ ucwords(__('site.address')) }}</th>
                            <th>{{ ucwords(__('site.add order')) }}</th>
                            <th>{{ ucwords(__('site.action')) }}</th>
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
                                            role="button">{{ ucwords(__('site.add order')) }}</a>
                                    @else
                                        <button class="btn btn-info disabled">{{ ucwords(__('site.add order')) }}</button>
                                    @endif
                                </td>

                                <td>
                                    @if (auth()->user()->hasPermission('clients_update'))
                                        <a class="btn btn-info" href="{{ route('dashboard.clients.edit', $client->id) }}"
                                            role="button">{{ ucwords(__('site.edit')) }}</a>
                                    @else
                                        <button class="btn btn-info disabled">{{ ucwords(__('site.edit')) }}</button>
                                    @endif
                                    @if (auth()->user()->hasPermission('clients_delete'))
                                        <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="POST"
                                            style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit"
                                                class="btn btn-danger">{{ ucfirst(__('site.delete')) }}</button>
                                        </form>
                                    @else
                                        <button
                                            class="btn btn-danger disabled">{{ ucwords(__('site.delete')) }}</button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination mt-4">{{ $clients->appends(request()->query())->links() }}</div>
            @else
                <h2>{{ ucwords(__('site.no data found')) }}</h2>
            @endif
        </div>
        <!-- /.card-body -->

    </div>
@endsection
