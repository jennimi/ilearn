@extends('layouts.app')

@section('content')
    <h1>Welcome, {{ $adminDetails->name }}</h1>
    <p>Email: {{ $adminDetails->email }}</p>

    <!-- Link to Create User -->
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-3">Create User</a>

    <!-- Section for All Classrooms -->
    <div class="mt-5">
        <h2>All Classrooms</h2>

        @if ($classrooms->isEmpty())
            <p>No classrooms found. <a href="{{ route('admin.classrooms.create') }}">Create a Classroom</a></p>
        @else
            <ul class="list-group">
                @foreach ($classrooms as $classroom)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $classroom->name }} ({{ $classroom->time_period }})
                        <a href="{{ route('admin.classrooms.show', $classroom->id) }}" class="btn btn-primary btn-sm">View Details</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
