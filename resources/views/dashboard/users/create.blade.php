@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.users create')) }} </h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(__('site.users create')) }}</h3>
        </div>


        <!-- /.card-header -->

        <div class="box-body">

            @include('partials._errors')


            <!-- form start -->
            <form action="{{ route('dashboard.users.store') }}" method="post" enctype="multipart/form-data">

                {{ csrf_field() }}
                {{ method_field('post') }}

                <div class="card-body">
                    <div class="form-group">
                        <label>{{ ucwords(__('site.first name')) }}</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}"
                            placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.first name')) }}">
                    </div>
                    <div class="form-group">
                        <label>{{ ucwords(__('site.last name')) }}</label>
                        <input type="text" name="last_name" class="form-control"
                            value="{{ old('last_name') }}"placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.last name')) }}">
                    </div>
                    <div class="form-group">
                        <label>{{ ucfirst(__('site.email')) }}</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email') }}"placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.email')) }}">
                    </div>
                    <div class="form-group">
                        <img src="{{ asset('uploads/users_image/default.png') }}" width="100px" class="img-thumbnail"
                            alt="default">
                    </div>
                    <div class="form-group">
                        <label>{{ ucwords(__('site.profile photo')) }}</label>
                        <input type="file" name="img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{ ucfirst(__('site.password')) }}</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.password')) }}">
                    </div>
                    <div class="form-group">
                        <label>{{ ucwords(__('site.password confirmation')) }}</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.password confirmation')) }}">
                    </div>

                    <h5 class="mt-4 mb-2">{{ ucfirst(__('site.permissions')) }}</h5>

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
                                                href="#{{ $model }}"
                                                data-toggle="tab">{{ __('site.' . $model) }}</a></li>
                                    @endforeach

                                </ul>


                                <div class="tab-content">

                                    @foreach ($models as $index => $model)
                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                            @foreach ($maps as $map)
                                                <label class="m-3"><input type="checkbox" name="permissions[]"
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
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">{{ ucfirst(__('site.add')) }}</button>
                </div>
            </form>
        </div><!-- end of div box body-->
    </div>
@endsection
