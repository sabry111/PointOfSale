@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.categories')) }}</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">{{ ucwords(__('site.categories')) }}</h1><br>

            <form action="{{ route('dashboard.categories.index') }}" method="get">
                <div class="mt-3 mb-3 float-left">

                    <input type="text" name="search" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" value="{{ request()->search }}">

                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">{{ ucwords(__('site.search')) }}</button>

                @if (auth()->user()->hasPermission('categories_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.categories.create') }}"
                        role="button">{{ ucwords(__('site.add')) }}</a>
                @else
                    <button class="btn btn-primary disabled">{{ ucwords(__('site.add')) }}</button>
                @endif

            </form>


        </div>
        <!-- /.card-header -->
        <div class="card-body">

            @if ($categories->count() > 0)
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>{{ ucwords(__('site.category name')) }}</th>
                            <th>{{ ucwords(__('site.product count')) }}</th>
                            <th>{{ ucwords(__('site.related product')) }}</th>
                            <th>{{ ucwords(__('site.action')) }}</th>
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
                                        role="button">{{ ucwords(__('site.related product')) }}</a></td>
                                <td>
                                    @if (auth()->user()->hasPermission('categories_update'))
                                        <a class="btn btn-info"
                                            href="{{ route('dashboard.categories.edit', $category->id) }}"
                                            role="button">{{ ucwords(__('site.edit')) }}</a>
                                    @else
                                        <button class="btn btn-info disabled">{{ ucwords(__('site.edit')) }}</button>
                                    @endif
                                    @if (auth()->user()->hasPermission('categories_delete'))
                                        <form action="{{ route('dashboard.categories.destroy', $category->id) }}"
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

                <div class="pagination mt-4">{{ $categories->appends(request()->query())->links() }}</div>
            @else
                <h2>{{ ucwords(__('site.no data found')) }}</h2>
            @endif
        </div>
        <!-- /.card-body -->

    </div>
@endsection
