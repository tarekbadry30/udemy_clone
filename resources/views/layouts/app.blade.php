<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body >
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img style="height: 75px" src="{{asset('img/logo.png')}}" class="img-fluid logo-img">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ translate('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @if(auth()->check()&&get_auth_user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ translate('dashboard') }}</a>
                    </li>
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto ">

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ translate('login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ translate('register') }}</a>
                            </li>

                        @endif
                    @else

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ translate('logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2 search-input" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{asset('/js/sweet-alert.min.js')}}"></script>
<script src="{{asset('/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>
@yield('js')
<script src="{{asset('/')}}js/fontawsome.js"></script>

</body>
</html>
