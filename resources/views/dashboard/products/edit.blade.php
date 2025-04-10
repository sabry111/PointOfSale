@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.products edit')) }}</h3>
@endsection


@section('content')
    <div class="card card-primary m-3">

        <!-- form start -->
        <form method="POST" action="{{ route('dashboard.products.update', $product->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="form-group">
                    <label>{{ ucwords(__('site.product name')) }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product descreption')) }}</label>
                    <textarea name="desc" class="form-control">{{ $product->desc }}</textarea>
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
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product stock')) }}</label>
                    <input type="text" name="stock" class="form-control" value="{{ $product->stock }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product purchase price')) }}</label>
                    <input type="text" name="purchase_price" step="0.01" class="form-control"
                        value="{{ $product->purchase_price }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.product sale price')) }}</label>
                    <input type="text" name="sale_price" step="0.01" class="form-control"
                        value="{{ $product->sale_price }}">
                </div>

                <button type="submit" class="btn btn-primary">{{ ucwords(__('site.edit')) }}</button>
            </div>
        </form>
    </div>
@endsection
