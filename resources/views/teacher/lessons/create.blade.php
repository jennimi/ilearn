@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Pelajaran</h1>

        <form method="POST" action="{{ route('teacher.lessons.store', $module->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Judul Pelajaran</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Unggah PDF</label>
                <input type="file" class="form-control" id="content" name="content" accept="application/pdf" required>
            </div>

            <div class="mb-3">
                <label for="visible" class="form-label">Terlihat</label>
                <select class="form-control" id="visible" name="visible">
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Pelajaran</button>
        </form>
    </div>
@endsection
