@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.clients create')) }}</h3>
@endsection


@section('content')
    <div class="card card-primary m-3">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(__('site.clients create')) }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('dashboard.clients.store') }}" method="post">

            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>{{ ucwords(__('site.client name')) }}</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.client name')) }}">
                </div>
                @for ($i = 0; $i < 2; $i++)
                    <div class="form-group">
                        <label>{{ ucwords(__('site.phone')) }}</label>
                        <input type="text" name="phone[]" class="form-control"
                            placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.phone')) }}">
                    </div>
                @endfor
                <div class="form-group">
                    <label>{{ ucwords(__('site.address')) }}</label>
                    <textarea name="address" class="form-control" placeholder="{{ ucwords(__('site.enter')) . ' ' . ucwords(__('site.address')) }}">{{ old('address') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">{{ ucwords(__('site.add')) }}</button>
            </div>
        </form>
    </div>
@endsection
