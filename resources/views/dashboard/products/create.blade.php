@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.products create')) }}</h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(__('site.products create')) }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('post') }}
            <div class="card-body">
                <div class="form-group">
                    <label>{{ ucwords(__('site.product name')) }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.product name')) }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product descreption')) }}</label>
                    <textarea name="desc" class="form-control"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.product descreption')) }}">{{ old('desc') }}</textarea>
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product photo')) }}</label>
                    <input type="file" name="img" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.select category')) }}</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product stock')) }}</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock') }}"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.product stock')) }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product purchase price')) }}</label>
                    <input type="number" name="purchase_price" step="0.01" class="form-control"
                        value="{{ old('purchase_price') }}"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.product purchase price')) }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product sale price')) }}</label>
                    <input type="number" name="sale_price" step="0.01" class="form-control"
                        value="{{ old('sale_price') }}"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.product sale price')) }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ ucwords(__('site.add')) }}</button>
            </div>
        </form>
    </div>
@endsection
