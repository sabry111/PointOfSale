@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Clients Create </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">Create Client</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.clients.store') }}" method="post">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Enter Name">
                </div>
                @for ($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone[]" class="form-control" placeholder="Enter Phone">
                    </div>
                @endfor
                <div class="form-group">
                    <label>Client Address</label>
                    <textarea name="address" class="form-control" placeholder="Enter Address">{{ old('address') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
@endsection
