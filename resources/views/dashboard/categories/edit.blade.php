@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Categories Edit </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">

        <!-- form start -->
        <form method="POST" action="{{ route('dashboard.categories.update') }}">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $categories->id }}">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $categories->name }}">
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </div>
@endsection
