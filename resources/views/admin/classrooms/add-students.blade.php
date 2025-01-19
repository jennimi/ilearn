@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-warning me-2">Kembali</a>
    </div>
    <h1 class="mb-3">Kelola Siswa untuk {{ $classroom->name }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Current Students Section -->
        <div class="col-md-6">
            <h3>Siswa Saat Ini</h3>

            @if ($classroom->students->isEmpty())
                <p>Tidak ada siswa yang saat ini terdaftar di kelas ini.</p>
            @else
                <form method="POST" action="{{ route('admin.classrooms.removeStudents', $classroom->id) }}">
                    @csrf
                    @method('DELETE')

                    <ul class="list-group">
                        @foreach ($classroom->students as $student)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $student->name }} (NIK: {{ $student->nik }})
                                <input type="checkbox" name="students[]" value="{{ $student->id }}">
                            </li>
                        @endforeach
                    </ul>

                    <button type="submit" class="btn btn-danger mt-3">Hapus Siswa yang Dipilih</button>
                </form>
            @endif
        </div>

        <!-- Available Students Section -->
        <div class="col-md-6">
            <h3>Tambah Siswa</h3>

            <div class="mb-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan NIK">
            </div>

            <form method="POST" action="{{ route('admin.classrooms.addStudents', $classroom->id) }}">
                @csrf

                <ul class="list-group" id="studentsContainer">
                    @foreach ($students as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $student->name }} (NIK: {{ $student->nik }})
                            <input type="checkbox" name="students[]" value="{{ $student->id }}">
                        </li>
                    @endforeach
                </ul>

                <button type="submit" class="btn btn-success mt-3">Tambah Siswa yang Dipilih</button>
            </form>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const studentsContainer = document.getElementById('studentsContainer');
    const listItems = document.querySelectorAll('#studentsContainer .list-group-item');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();

        listItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
@endsection
