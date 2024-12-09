@extends('layouts.app')

@section('content')
    <h1>Welcome, {{ $adminDetails->name }}</h1>
    <p>Email: {{ $adminDetails->email }}</p>
@endsection
