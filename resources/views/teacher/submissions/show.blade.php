@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detail Pengumpulan</h1>
        <p><strong>Nama Siswa:</strong> {{ $submission->student->name }}</p>
        <p><strong>Tugas:</strong> {{ $submission->assignment->title }}</p>
        <p><strong>Tanggal Pengumpulan:</strong> {{ $submission->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Nilai:</strong> {{ $submission->grade ?? 'Belum Dinilai' }}</p>

        <div class="mt-4">
            <a href="{{ asset('storage/' . $submission->file) }}" target="_blank" class="btn btn-success">
                Lihat File Pengumpulan
            </a>
        </div>
    </div>
@endsection
