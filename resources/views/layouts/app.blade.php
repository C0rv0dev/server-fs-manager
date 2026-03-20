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
            width: 250px;
            overflow-y: auto;
            z-index: 1000;
            padding-right: 0;
            padding-left: 0;
            border-right: 1px solid #dee2e6;
            background-color: #fff;
        }

        .app-sidebar.offcanvas {
            width: 250px;
        }

        .main-content {
            padding: 20px;
            margin-left: 250px;
        }

        .mobile-sidebar-toggle {
            display: none;
        }

        @media (min-width: 768px) {
            .app-sidebar {
                position: fixed;
            }

            .main-content {
                margin-left: 250px;
            }

            .app-sidebar.offcanvas {
                transform: none !important;
                visibility: visible !important;
                z-index: 1000;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                margin-top: 60px;
                margin-left: 0 !important;
            }

            .mobile-sidebar-toggle {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        @auth
            <div class="mobile-sidebar-toggle bg-white p-2 w-100 shadow-sm">

            <button class="btn btn-outline-secondary d-md-none m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#appSidebar" aria-controls="appSidebar" aria-label="{{ __('Toggle sidebar') }}">
                <i class="fa-solid fa-bars"></i>
            </button>
            </div>
        @endauth

        <main>
            @auth
                <aside id="appSidebar" class="col-md-3 app-sidebar offcanvas offcanvas-start d-md-block" tabindex="-1" aria-labelledby="sidebarLabel" data-bs-scroll="true" data-bs-backdrop="false">
                    <div class="offcanvas-header d-md-none">
                        <h5 id="sidebarLabel" class="offcanvas-title">{{ config('app.name', 'Laravel') }}</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="{{ __('Close') }}"></button>
                    </div>

                    <div class="offcanvas-body p-0 h-100 d-flex flex-column">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item">
                                <div class="d-flex flex-column align-items-center justify-content-between">

                                    {{-- avatar --}}
                                    <div class="avatar me-2">
                                        {{-- square placeholder --}}
                                        <canvas width="40" height="40" class="rounded-circle">
                                            <script>
                                                const canvas = document.querySelector('canvas');
                                                const ctx = canvas.getContext('2d');
                                                ctx.fillStyle = 'gray';
                                                ctx.fillRect(0, 0, 40, 40);
                                            </script>
                                        </canvas>
                                    </div>

                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <div class="small text-muted">{{ Auth::user()->email }}</div>
                                </div>
                            </a>

                            <x-layouts.sidebar-item
                                :route="'home'"
                                :label="'Home'"
                                :small="'Display recent archives'"
                                :icon="'fa-solid fa-home'"
                                :active="request()->routeIs('home')"
                            />

                            <x-layouts.sidebar-item
                                :route="'archives.create'"
                                :label="'Create'"
                                :small="'Upload archives'"
                                :icon="'fa-solid fa-plus'"
                                :active="request()->routeIs('archives.create')"
                            />

                            <x-layouts.sidebar-item
                                :route="'archives.index'"
                                :label="'Files'"
                                :small="'Display paginated files'"
                                :icon="'fa-solid fa-file'"
                                :active="request()->routeIs('archives.index')"
                            />

                            <x-layouts.sidebar-item
                                :route="'archives.starred'"
                                :label="'Starred'"
                                :small="'Favorite archives'"
                                :icon="'fa-solid fa-star'"
                                :active="request()->routeIs('archives.starred')"
                            />

                            <x-layouts.sidebar-item
                                :route="'archives.trashed'"
                                :label="'Trash'"
                                :small="'Deleted archives'"
                                :icon="'fa-solid fa-trash'"
                                :active="request()->routeIs('archives.trashed')"
                            />
                        </div>

                        {{-- Logout and version pinned to bottom --}}
                        <div class="p-3 mt-auto">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">Logout</button>
                            </form>

                            <div class="small text-muted text-center mt-2">
                                Version: {{ config('app.version', 'v1.0') }}
                            </div>
                        </div>
                    </div>
                </aside>
            @endauth

            <div class="@auth main-content @else d-flex justify-content-center align-items-center vh-100 @endauth">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
