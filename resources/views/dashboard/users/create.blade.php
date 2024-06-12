@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Users Create </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">Create User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}"
                        placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control"
                        value="{{ old('last_name') }}"placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email') }}"placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <img src="{{ asset('uploads/users_image/default.png') }}" width="100px" class="img-thumbnail"
                        alt="default">
                </div>
                <div class="form-group">
                    <label>Profile Photo</label>
                    <input type="file" name="img" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <label>Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Enter Password Confirmation">
                </div>

                <h5 class="mt-4 mb-2">Permissions</h5>

                <div class="row">
                    <div class="col-12">
                        <!-- Custom Tabs -->
                        <div class="card">


                            @php
                                $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                $maps = ['create', 'read', 'update', 'delete'];
                            @endphp

                            <ul class="nav nav-pills p-2">
                                @foreach ($models as $index => $model)
                                    <li class="nav-item"><a class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                            href="#{{ $model }}" data-toggle="tab">{{ $model }}</a></li>
                                @endforeach

                            </ul>


                            <div class="tab-content">

                                @foreach ($models as $index => $model)
                                    <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                        @foreach ($maps as $map)
                                            <label class="m-3"><input type="checkbox" name="permissions[]"
                                                    value="{{ $model . '_' . $map }}">{{ $map }}</label>
                                        @endforeach
                                    </div>
                                @endforeach

                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->

                        </div>
                        <!-- ./card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
@endsection
