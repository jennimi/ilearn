@php
    if (auth()->check()) {
        // Logs out the user
        auth()->logout();

        // Invalidate the session
        request()->session()->invalidate();

        // Regenerate the session token
        request()->session()->regenerateToken();
    }
@endphp
{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>iLearn - Landing Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS (via CDN with tw- prefix support) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
        };
    </script>

    <style>
        .tw-bg-image {
            background-image: url('https://www.learnlight.com/wp-content/uploads/2019/05/effective_blended-learning_i_dr911-e1558962499884.jpg');
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
    </style>
</head>

<body class="tw-bg-gray-100 tw-h-screen tw-flex tw-flex-col tw-items-center tw-justify-center tw-text-center">
    <!-- Background Image -->

</body>

</html> --}}

@extends('layouts.app')

@section('content')
    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-text-center">
        <div class="tw-bg-image"></div>

        <!-- Header -->
        <h1 class="tw-text-6xl tw-font-bold tw-text-gray-800 tw-mb-8">
            Welcome to iLearn
        </h1>

        <!-- Container -->
        <div class="container tw-bg-white tw-shadow-lg tw-rounded-lg tw-p-8 tw-max-w-lg">
            <p class="tw-text-gray-600 tw-mb-6">
                Your ultimate Learning Management System for seamless and engaging education experiences.
            </p>

            <!-- Centered Login Button -->
            <a href="{{ route('login') }}"
                class="btn btn-primary tw-w-full tw-bg-blue-500 tw-py-3 tw-text-white tw-rounded-lg tw-hover:bg-blue-600">
                Log In
            </a>
        </div>
        <a href="{{ route('gemini.ask') }}">
            <img src="{{ asset('assets/jamir.png') }}" alt="Placeholder">
        </a>
    </div>
@endsection
