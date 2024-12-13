@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-warning me-2">Back</a>
        </div>

        <h2 class="mb-4">Users</h2>

        <!-- Toggle Buttons -->
        <div class="mb-4">
            <a href="{{ route('admin.users.index', ['type' => 'students']) }}"
                class="btn {{ request('type') === 'students' ? 'btn-primary' : 'btn-outline-primary' }}">
                Students
            </a>
            <a href="{{ route('admin.users.index', ['type' => 'teachers']) }}"
                class="btn {{ request('type') === 'teachers' ? 'btn-primary' : 'btn-outline-primary' }}">
                Teachers
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
                                <p class="card-text">Date of Birth :{{ $student->date_of_birth }}</p>
                                <p class="card-text">Phone Number : {{ $student->phone_number }}</p>
                                <p class="card-text">Enrollment Date : {{ $student->enrollment_date }}</p>
                                <p class="card-text">
                                    <span class="badge bg-success">{{ ucfirst($student->role) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No students found.</p>
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
                                    Date of Birth : {{ $teacher->date_of_birth }}
                                </p>
                                <p class="card-text">
                                    Phone Number : {{ $teacher->phone_number }}
                                </p>
                                <p class="card-text">
                                    <span class="badge bg-info">{{ ucfirst($teacher->role) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No teachers found.</p>
                @endforelse
            </div>
        @else
            <p class="text-muted">Please select a user type to view.</p>
        @endif

        <!-- Pagination -->
        @if ($users->hasPages())
            <nav>
                <ul class="pagination justify-content-center">
                    @if ($users->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo; Previous</span></li>
                    @else
                        <li class="page-item"><a class="page-link"
                                href="{{ $users->previousPageUrl() }}&type={{ $type }}">&laquo; Previous</a></li>
                    @endif

                    @foreach ($users->links()->elements[0] as $page => $url)
                        <li class="page-item {{ $users->currentPage() === $page ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $url }}&type={{ $type }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($users->hasMorePages())
                        <li class="page-item"><a class="page-link"
                                href="{{ $users->nextPageUrl() }}&type={{ $type }}">Next &raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next &raquo;</span></li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
@endsection
