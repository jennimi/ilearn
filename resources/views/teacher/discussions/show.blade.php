@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $discussion->title }}</h1>
    <p>Module: {{ $discussion->module->title }}</p>
    <p>{{ $discussion->module->description }}</p>
    <h5>Teacher: {{ $discussion->teacher->name }}</h5>
</div>
@endsection
