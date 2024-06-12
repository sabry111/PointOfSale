@extends('layouts.dashboard.master')


@section('title_page')
    <h3>Clients Edit </h3>
@endsection


@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <div class="card card-primary m-3">

        <!-- form start -->
        <form method="POST" action="{{ route('dashboard.clients.update') }}">
            @csrf
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $clients->id }}">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $clients->name }}">
                </div>

                @for ($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone[]" class="form-control" value="{{ $clients->phone[$i] ?? '' }}">
                    </div>
                @endfor
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control">{{ $clients->address }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </div>
@endsection
