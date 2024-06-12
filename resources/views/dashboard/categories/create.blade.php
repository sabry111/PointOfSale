@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Categories Create </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">Create Category</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.categories.store') }}" method="post">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Enter Name">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
@endsection
