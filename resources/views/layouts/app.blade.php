<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('iLearn', 'iLearn') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/iLearn-logo.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('images/iLearn-logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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
        body,
        html {
            font-family: 'Poppins', sans-serif;
        }

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
            background-image: url('https://img.freepik.com/premium-vector/texture-background-hd-vector-image_887635-52.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(5px);
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

        .fancy-input {
            position: relative;
            margin-bottom: 1rem;
        }

        /* Hide the default radio and checkbox input */
        .form-check-input {
            opacity: 0;
            position: absolute;
            width: 0;
            /* Ensure it doesn't take up any space */
            height: 0;
            /* Ensure it doesn't take up any space */
        }

        /* Custom label for radio and checkbox */
        .form-check-label {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border: 2px solid #ddd;
            border-radius: 0.5rem;
            background: #f9f9f9;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-left: 0;
            /* Remove any extra left margin */
        }

        /* Hover effect for labels */
        .form-check-label:hover {
            background: #eaeaea;
            border-color: #ccc;
        }

        /* When the radio or checkbox is checked */
        .form-check-input:checked+.form-check-label {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Custom indicator styling */
        .form-check-label::before {
            content: '';
            display: inline-block;
            width: 1rem;
            height: 1rem;
            margin-right: 1rem;
            border: 2px solid #ddd;
            background: white;
            transition: all 0.3s ease-in-out;
        }

        /* Radio buttons remain circular */
        input[type="radio"]+.form-check-label::before {
            border-radius: 50%;
        }

        /* Checkboxes remain square */
        input[type="checkbox"]+.form-check-label::before {
            border-radius: 0;
        }

        /* When radio is checked, change the circle appearance */
        input[type="radio"]:checked+.form-check-label::before {
            background: #fff;
            border-color: #fff;
            box-shadow: inset 0 0 0 4px #007bff;
        }

        /* When checkbox is checked, change the square appearance */
        input[type="checkbox"]:checked+.form-check-label::before {
            background: #fff;
            border-color: #fff;
            box-shadow: inset 0 0 0 4px #007bff;
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                {{-- <a class="navbar-brand text-white" href="{{ url('/') }}">
                    {{ config('iLearn', 'iLearn') }}
                </a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <img src="{{ asset('images/iLearn-logo.png') }}" alt="iLearn Logo"
                            class="tw-w-10 tw-h-10 tw-me-2">
                        @if (auth()->check() && auth()->user()->role === 'admin' && auth()->user()->admin)
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">iLearn</a>
                        @elseif(auth()->check() && auth()->user()->role === 'teacher' && auth()->user()->teacher)
                            <a class="nav-link text-white" href="{{ route('teacher.dashboard') }}">iLearn</a>
                        @elseif(auth()->check() && auth()->user()->role === 'student' && auth()->user()->student)
                            <a class="nav-link text-white" href="{{ route('student.dashboard') }}">iLearn</a>
                        @else
                            <a class="nav-link text-white" href="{{ route('home') }}">iLearn</a>
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
