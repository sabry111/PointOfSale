<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard.index') }}" class="nav-link">{{ ucwords(__('site.home')) }}</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- <!-- Tasks: style can be found in dropdown.less --> --}}
        <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag"></i></a>
            <ul class="dropdown-menu">
                <li>
                    {{-- <!-- inner menu: contains the actual data --> --}}
                    <ul class="menu">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>

        {{-- <!-- User Account: style can be found in dropdown.less --> --}}
        <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('uploads/users_image/' . auth()->user()->img) }}" class="user-image"
                    alt="User Image">
                <span class="hidden-xs">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
            </a>
            <ul class="dropdown-menu">

                {{-- <!-- User image --> --}}
                <li class="user-header">
                    <img src="{{ asset('uploads/users_image/' . auth()->user()->img) }}" class="img-circle"
                        alt="User Image">

                    <p>
                        {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                        <small>Member since 2 days</small>
                    </p>
                </li>

                {{-- <!-- Menu Footer--> --}}
                <li class="user-footer">


                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                        onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">@lang('site.logout')</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
