@extends('layouts.app')

@section('content')
    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-h-screen tw-text-center">
        <h1 class="tw-text-6xl tw-font-bold tw-text-gray-800 mb-4">Page Not Found</h1>
        <p class="tw-text-gray-600 mb-8">
            Sorry, the page you are looking for does not exist. Redirecting you to the appropriate page...
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
    </div>

    <script>
        @if (Auth::check())
            @if (Auth::user()->role === 'admin')
                window.location.href = "{{ route('admin.dashboard') }}";
            @elseif (Auth::user()->role === 'teacher')
                window.location.href = "{{ route('teacher.dashboard') }}";
            @elseif (Auth::user()->role === 'student')
                window.location.href = "{{ route('student.dashboard') }}";
            @else
                window.location.href = "{{ route('home') }}";
            @endif
        @else
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 5000);
        @endif
    </script>
@endsection
