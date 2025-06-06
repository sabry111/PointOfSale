@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucfirst(__('site.users edit')) }} </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">

        <!-- form start -->
        <form method="POST" action="{{ route('dashboard.users.update', $user->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="form-group">
                    <label>{{ ucwords(__('site.first name')) }}</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.last name')) }}</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.email')) }}</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <img src="{{ asset('uploads/users_image/' . $user->img) }}" width="100px" class="img-thumbnail"
                        alt="">
                </div>
                <div class="form-group">
                    <label>{{ ucwords(__('site.profile photo')) }}</label>
                    <input type="file" name="img" class="form-control">
                </div>
                <h5 class="mt-4 mb-2">{{ ucwords(__('site.permissions')) }}</h5>

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
                                            href="#{{ $model }}" data-toggle="tab">{{ __('site.' . $model) }}</a>
                                    </li>
                                @endforeach

                            </ul>


                            <div class="tab-content">

                                @foreach ($models as $index => $model)
                                    <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                        @foreach ($maps as $map)
                                            <label class="m-3"><input type="checkbox"
                                                    {{ $user->haspermission($model . '_' . $map) ? 'checked' : '' }}
                                                    name="permissions[]"
                                                    value="{{ $model . '_' . $map }}">{{ __('site.' . $map) }}</label>
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

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{ ucwords(__('site.edit')) }}</button>
    </div>
    </form>
    </div>
@endsection
