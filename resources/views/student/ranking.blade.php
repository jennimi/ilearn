@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Peringkat Kelas</h1>
        <p class="text-muted">{{ $classroom->name }} - {{ $classroom->time_period }}</p>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Skor</th>
                        <th>Progres</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student['name'] }}</td>
                            <td>{{ $student['score'] }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div
                                        class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: {{ $student['progress'] }}%;"
                                        aria-valuenow="{{ $student['progress'] }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ $student['progress'] }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
