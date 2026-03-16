<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .app-sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            bottom: 0;
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
            padding-right: 0;
            padding-left: 0;
            border-right: 1px solid #dee2e6;
        }

        .main-with-sidebar {
            margin-left: 250px;
            margin-top: 3rem;
        }

        @media (max-width: 767.98px) {
            .app-sidebar {
                position: static;
                width: 100%;
                top: auto;
                bottom: auto;
                height: auto;
            }

            .main-with-sidebar {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container py-4">
            <div class="row">
                @auth
                    <aside class="col-md-3 app-sidebar">
                        <div class="h-100 d-flex flex-column p-0">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <i class="fa-solid fa-house"></i>
                                    Home
                                    <div class="small">Display 10 recent files</div>
                                </a>
                                <a href="{{ route('files.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('files.*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-file"></i>
                                    Files
                                    <div class="small">Display paginated files</div>
                                </a>
                                <a href="{{ route('archives.starred') }}" class="list-group-item list-group-item-action {{ request()->routeIs('archives.starred') ? 'active' : '' }}">
                                    <i class="fa-solid fa-star"></i>
                                    Starred
                                    <div class="small">Favorite files</div>
                                </a>
                            </div>

                            <!-- App version pinned to the bottom of the sidebar -->
                            <div class="p-3 mt-auto small text-muted text-center">
                                Version: {{ config('app.version', 'v1.0') }}
                            </div>
                        </div>
                    </aside>
                @endauth

                <main class="@auth col-md-9 main-with-sidebar @else col-md-12 mt-5 @endauth">
                    <div class="py-2">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
