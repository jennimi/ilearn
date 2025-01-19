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
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 10px;
        }

        .schedule-scroll-horizontal::-webkit-scrollbar {
            height: 8px;
        }

        .schedule-scroll-horizontal::-webkit-scrollbar-thumb {
            background: #007bff;
            border-radius: 10px;
        }

        .schedule-scroll-horizontal::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .fancy-input {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-check-input-take {
            opacity: 0;
            position: absolute;
            width: 0;
            height: 0;
        }

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
        }

        .form-check-label:hover {
            background: #eaeaea;
            border-color: #ccc;
        }

        .form-check-input:checked+.form-check-label {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

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

        input[type="radio"]+.form-check-label::before {
            border-radius: 50%;
        }

        input[type="checkbox"]+.form-check-label::before {
            border-radius: 0;
        }

        input[type="radio"]:checked+.form-check-label::before {
            background: #fff;
            border-color: #fff;
            box-shadow: inset 0 0 0 4px #007bff;
        }

        input[type="checkbox"]:checked+.form-check-label::before {
            background: #fff;
            border-color: #fff;
            box-shadow: inset 0 0 0 4px #007bff;
        }

        .notranslate {
            unicode-bidi: isolate;
        }
    </style>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <img src="{{ asset('images/iLearn-logo.png') }}" alt="iLearn Logo"
                            class="tw-w-10 tw-h-10 tw-me-2">
                        @if (auth()->check() && auth()->user()->role === 'admin' && auth()->user()->admin)
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}"><span
                                    class="notranslate">iLearn</span></a>
                        @elseif(auth()->check() && auth()->user()->role === 'teacher' && auth()->user()->teacher)
                            <a class="nav-link text-white" href="{{ route('teacher.dashboard') }}"><span
                                    class="notranslate">iLearn</span></a>
                        @elseif(auth()->check() && auth()->user()->role === 'student' && auth()->user()->student)
                            <a class="nav-link text-white" href="{{ route('student.dashboard') }}"><span
                                    class="notranslate">iLearn</span></a>
                        @else
                            <a class="nav-link text-white" href="{{ route('home') }}">iLearn</a>
                        @endif
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <div id="language-select" class="d-flex align-items-center">
                            <label for="languageDropdown" class="text-white me-2">Language:</label>
                            <select id="languageDropdown" class="form-select form-select-sm bg-light border-0 shadow-sm" style="width: auto;" onchange="translateLanguage(this.value)">
                                <option value="id">Bahasa Indonesia</option>
                                <option value="en">English</option>
                            </select>
                        </div>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
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
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'id',
                    includedLanguages: 'en,id',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                },
                'google_translate_element'
            );
        }

        function translateLanguage(lang) {
            var googleTranslateCookie = `googtrans=/id/${lang}; domain=.${location.hostname}; path=/`;
            document.cookie = googleTranslateCookie;
            document.cookie = googleTranslateCookie.replace("googtrans", "googtrans");
            location.reload();
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>
