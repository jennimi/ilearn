@extends('layouts.app')

@section('content')
    <h1>Welcome, {{ $adminDetails->name }}</h1>
    <p>Email: {{ $adminDetails->email }}</p>

    <!-- Link to Create User -->
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-3">Create User</a>
@endsection
