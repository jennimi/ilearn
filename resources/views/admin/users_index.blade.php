@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning me-2"><i
                    class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Kembali</span></a>
        </div>

        <h2 class="mb-4">Pengguna</h2>

        <!-- Toggle Buttons -->
        <div class="mb-4">
            <a href="{{ route('admin.users.index', ['type' => 'students']) }}"
                class="btn {{ request('type') === 'students' ? 'btn-primary' : 'btn-outline-primary' }}">
                Siswa
            </a>
            <a href="{{ route('admin.users.index', ['type' => 'teachers']) }}"
                class="btn {{ request('type') === 'teachers' ? 'btn-primary' : 'btn-outline-primary' }}">
                Guru
            </a>
        </div>

        <!-- Display Users Based on Selection -->
        @if ($type === 'students')
            <div class="row">
                @forelse ($users as $student)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $student->name }}</h5>
                                <p class="card-text">NIK : {{ $student->nik }}</p>
                                <p class="card-text">Email : {{ $student->email }}</p>
                                <p class="card-text">Tanggal Lahir : {{ $student->date_of_birth }}</p>
                                <p class="card-text">Nomor Telepon : {{ $student->phone_number }}</p>
                                <p class="card-text">Tanggal Pendaftaran : {{ $student->enrollment_date }}</p>
                                <p class="card-text">
                                    <span class="badge bg-success">{{ ucfirst($student->role) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada siswa ditemukan.</p>
                @endforelse
            </div>
        @elseif ($type === 'teachers')
            <div class="row">
                @forelse ($users as $teacher)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $teacher->name }}</h5>
                                <p class="card-text">Email : {{ $teacher->email }}</p>
                                <p class="card-text">
                                    Tanggal Lahir : {{ $teacher->date_of_birth }}
                                </p>
                                <p class="card-text">
                                    Nomor Telepon : {{ $teacher->phone_number }}
                                </p>
                                <p class="card-text">
                                    <span class="badge bg-info">{{ ucfirst($teacher->role) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Tidak ada guru ditemukan.</p>
                @endforelse
            </div>
        @else
            <p class="text-muted">Silakan pilih jenis pengguna untuk melihat.</p>
        @endif

        <!-- Pagination -->
        @if ($users->hasPages())
            <nav>
                <ul class="pagination justify-content-center">
                    @if ($users->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo; Sebelumnya</span></li>
                    @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $users->previousPageUrl() }}&type={{ $type }}">&laquo; Sebelumnya</a></li>
                    @endif

                    @foreach ($users->links()->elements[0] as $page => $url)
                        <li class="page-item {{ $users->currentPage() === $page ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $url }}&type={{ $type }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($users->hasMorePages())
                        <li class="page-item"><a class="page-link"
                                href="{{ $users->nextPageUrl() }}&type={{ $type }}">Berikutnya &raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Berikutnya &raquo;</span></li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
@endsection
