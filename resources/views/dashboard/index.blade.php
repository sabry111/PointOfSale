@extends('layouts.dashboard.master')


@section('title_page')
    <h3>{{ ucwords(__('site.users')) }}</h3>
@endsection


@section('content')
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $categories_count }}</h3>

                        <p>{{ ucwords(__('site.categories')) }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('dashboard.categories.index') }}"
                        class="small-box-footer">{{ ucfirst(__('site.more info')) }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $products_count }}</h3>

                        <p>{{ ucwords(__('site.products')) }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('dashboard.products.index') }}"
                        class="small-box-footer">{{ ucfirst(__('site.more info')) }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $clients_count }}</h3>

                        <p>{{ ucwords(__('site.clients')) }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ route('dashboard.clients.index') }}"
                        class="small-box-footer">{{ ucfirst(__('site.more info')) }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $users_count }}</h3>

                        <p>{{ ucwords(__('site.users')) }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="{{ route('dashboard.users.index') }}"
                        class="small-box-footer">{{ ucfirst(__('site.more info')) }} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </section>
@endsection
