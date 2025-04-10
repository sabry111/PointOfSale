@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.category create')) }}</h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(__('site.category create')) }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.categories.store') }}" method="post">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>{{ ucwords(__('site.category name')) }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.category name')) }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ ucwords(__('site.add')) }}</button>
            </div>
        </form>
    </div>
@endsection
