@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Users</h3>
@endsection


@section('content')
    <div class="card m-3">
        <div class="card-header">
            <h1 class="card-title">Users <small>{{ $users->total() }}</small></h1><br>

            <form action="{{ route('dashboard.users.index') }}" method="get">
                <div class="mt-3 mb-3 float-left">

                    <input type="text" name="search" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" value="{{ request()->search }}">

                </div>

                <button type="submit" class="btn btn-primary mt-3 mb-3 ml-3">Serach</button>
                @if (auth()->user()->hasPermission('users_create'))
                    <a class="btn btn-primary " href="{{ route('dashboard.users.create') }}" role="button">Add</a>
                @else
                    <button class="btn btn-primary disabled">Add</button>
                @endif
            </form>


        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>First name</th>
                        <th>Last Name</th>
                        <th>Profile Photo</th>
                        <th>Email</th>
                        <th style="width:15%">Action</th>
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
                                        role="button">Edit</a>
                                @else
                                    <button class="btn btn-info disabled">Edit</button>
                                @endif
                                @if (auth()->user()->hasPermission('users_delete'))
                                    <a class="btn btn-danger" href="{{ route('dashboard.users.delete', $user->id) }}"
                                        role="button">Delete</a>
                                @else
                                    <button class="btn btn-danger disabled">Delete</button>
                                @endif

                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>

            <div class="pagination mt-4">{{ $users->appends(request()->query())->links() }}</div>

        </div>
        <!-- /.card-body -->

    </div>
@endsection
