@extends('layouts.dashboard.master')


@section('title_page')
    <h3> {{ ucfirst(__('site.users')) }} </h3>
@endsection


@section('content')
    @include('partials._session')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">{{ ucfirst(__('site.users')) }} <small>{{ $users->total() }}</small></h1><br>

            <form action="{{ route('dashboard.users.index') }}" method="get">
                <div class="mt-3 mb-3 float-left">

                    <input type="text" name="search" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="{{ __('site.search') }}" value="{{ request()->search }}">

                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">{{ ucfirst(__('site.search')) }}</button>
                @if (auth()->user()->hasPermission('users_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.users.create') }}"
                        role="button">{{ ucfirst(__('site.add')) }}</a>
                @else
                    <button class="btn btn-primary disabled">{{ ucfirst(__('site.add')) }}</button>
                @endif
            </form>


        </div>
        <!-- /.card-header -->
        <div class="card-body">

            @if ($users->count() > 0)
                <table class="table table-bordered ">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>{{ ucwords(__('site.first name')) }}</th>
                            <th>{{ ucwords(__('site.last name')) }}</th>
                            <th>{{ ucwords(__('site.profile photo')) }}</th>
                            <th>{{ ucfirst(__('site.email')) }}</th>
                            <th style="width:15%">{{ ucfirst(__('site.action')) }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td> <img src="{{ asset('uploads/users_image/' . $user->img) }}" width="100px"
                                        class="img-thumbnail" alt=""></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if (auth()->user()->hasPermission('users_update'))
                                        <a class="btn btn-info" href="{{ route('dashboard.users.edit', $user->id) }}"
                                            role="button">{{ ucfirst(__('site.edit')) }}</a>
                                    @else
                                        <button class="btn btn-info disabled">{{ ucfirst(__('site.edit')) }}</button>
                                    @endif
                                    @if (auth()->user()->hasPermission('users_delete'))
                                        {{-- <a class="btn btn-danger" href="{{ route('dashboard.users.destroy', $user->id) }}"
                                        role="button">{{ ucfirst(__('site.delete')) }}</a> --}}
                                        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST"
                                            style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit"
                                                class="btn btn-danger">{{ ucfirst(__('site.delete')) }}</button>
                                        </form>
                                    @else
                                        <button class="btn btn-danger disabled">{{ ucfirst(__('site.delete')) }}</button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>

                <div class="pagination mt-4">{{ $users->appends(request()->query())->links() }}</div>
            @else
                <h2>{{ ucwords(__('site.no data found')) }}</h2>
            @endif
        </div>
        <!-- /.card-body -->

    </div>
@endsection
