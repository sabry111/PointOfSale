@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.clients edit')) }} </h3>
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
        <form method="POST" action="{{ route('dashboard.clients.update', $client->id) }}">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="card-body">
                <input type="hidden" name="id" value="{{ $client->id }}">
                <div class="form-group">
                    <label>{{ ucwords(__('site.client name')) }}</label>
                    <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                </div>

                @for ($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>{{ ucwords(__('site.phone')) }}</label>
                        <input type="text" name="phone[]" class="form-control" value="{{ $client->phone[$i] ?? '' }}">
                    </div>
                @endfor
                <div class="form-group">
                    <label>{{ ucwords(__('site.address')) }}</label>
                    <textarea name="address" class="form-control">{{ $client->address }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">{{ ucwords(__('site.edit')) }}</button>
            </div>
        </form>
    </div>
@endsection
