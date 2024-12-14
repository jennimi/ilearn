<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'iLearn') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Full Calendar -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid/main.min.js"></script>


    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Opera */
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            /* For Internet Explorer and Edge */
            scrollbar-width: none;
            /* For Firefox */
        }

        .tw-bg-image {
            background-image: url('https://michiganvirtual.org/wp-content/uploads/2019/11/blended-v-student-centered-learning-1024x581.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .schedule-scroll-horizontal {
            max-width: 100%;
            /* Ensures it doesn’t overflow the container */
            overflow-x: auto;
            /* Horizontal scrolling */
            scroll-behavior: smooth;
            /* Smooth scrolling */
            padding-bottom: 10px;
            /* Space for better appearance */
        }

        .schedule-scroll-horizontal::-webkit-scrollbar {
            height: 8px;
            /* Thin horizontal scrollbar */
        }

        .schedule-scroll-horizontal::-webkit-scrollbar-thumb {
            background: #007bff;
            /* Match primary color */
            border-radius: 10px;
            /* Rounded scrollbar */
        }

        .schedule-scroll-horizontal::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Light track */
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand text-white" href="{{ url('/') }}">
                    {{ config('app.name', 'iLearn') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (auth()->check() && auth()->user()->role === 'admin' && auth()->user()->admin)
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @elseif(auth()->check() && auth()->user()->role === 'teacher' && auth()->user()->teacher)
                            <a class="nav-link text-white" href="{{ route('teacher.dashboard') }}">Dashboard</a>
                        @elseif(auth()->check() && auth()->user()->role === 'student' && auth()->user()->student)
                            <a class="nav-link text-white" href="{{ route('student.dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link text-white" href="{{ route('home') }}">Dashboard</a>
                        @endif

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            {{--
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    {{-- Tailwind --}}
    <script>
        tailwind.config = {
            prefix: "tw-",
            corePlugins: {
                preflight: false,
            }
        }
    </script>
</body>

</html>
