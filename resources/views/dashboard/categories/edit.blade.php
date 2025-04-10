@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.category edit')) }} </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">

        <!-- form start -->
        <form method="POST" action="{{ route('dashboard.categories.update', $category->id) }}">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="card-body">
                <div class="form-group">
                    <label>{{ ucwords(__('site.category name')) }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                </div>

                <button type="submit" class="btn btn-primary">{{ ucwords(__('site.edit')) }}</button>
            </div>
        </form>
    </div>
@endsection
