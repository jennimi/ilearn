@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <button onclick="window.history.back()" class="btn btn-warning me-2">
                <i class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Back</span>
            </button>
        </div>        
        <h1>{{ $assignment->title }}</h1>
        <p>{{ $assignment->description }}</p>
        <p><strong>Deadline:</strong> {{ $assignment->deadline }}</p>
        <p><strong>Visibility:</strong> {{ $assignment->visible ? 'Visible' : 'Hidden' }}</p>

        <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" class="btn btn-primary mt-4">Edit Assignment</a>
        <button type="button" class="btn btn-outline-danger mt-4" data-bs-toggle="modal"
            data-bs-target="#deleteAssignmentModal{{ $assignment->id }}">
            Delete
        </button>

        <!-- Classroom Buttons -->
        <div class="mt-5">
            <h2>Classrooms</h2>
            @if ($classrooms->isEmpty())
                <p class="text-danger">No classrooms associated with this assignment.</p>
            @else
                @foreach ($classrooms as $classroom)
                    <button type="button" class="btn btn-outline-primary btn-lg mt-2" data-bs-toggle="modal"
                        data-bs-target="#classroomSubmissionsModal{{ $classroom->id }}">
                        View Submissions for {{ $classroom->name }}
                    </button>

                    <!-- Modal for Classroom Submissions -->
                    <div class="modal fade" id="classroomSubmissionsModal{{ $classroom->id }}" tabindex="-1"
                        aria-labelledby="classroomSubmissionsModalLabel{{ $classroom->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="classroomSubmissionsModalLabel{{ $classroom->id }}">
                                        Submissions for {{ $classroom->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @php
                                        $submissions = $assignment->submissions->where(
                                            'student.classroom_id',
                                            $classroom->id,
                                        );
                                    @endphp

                                    @if ($submissions->isEmpty())
                                        <p class="text-danger">No submissions for this classroom.</p>
                                    @else
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Submission Date</th>
                                                    <th>Grade</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($submissions as $submission)
                                                    <tr>
                                                        <td>{{ $submission->student->name }}</td>
                                                        <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                                                        <td>
                                                            <form method="POST"
                                                                action="{{ route('teacher.submissions.update', $submission->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="number" name="grade" class="form-control"
                                                                    value="{{ $submission->grade ?? '' }}" min="0">
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $submission->file_path) }}"
                                                                target="_blank" class="btn btn-sm btn-success">
                                                                Download
                                                            </a>
                                                            <button type="submit"
                                                                form="updateGradeForm{{ $submission->id }}"
                                                                class="btn btn-sm btn-primary">
                                                                Save Grade
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Delete Assignment Modal -->
        <div class="modal fade" id="deleteAssignmentModal{{ $assignment->id }}" tabindex="-1"
            aria-labelledby="deleteAssignmentModalLabel{{ $assignment->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('teacher.assignments.destroy', $assignment->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAssignmentModalLabel{{ $assignment->id }}">
                                Delete Assignment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the assignment
                                <strong>{{ $assignment->title }}</strong>?
                            </p>
                            <p class="text-danger">
                                This will delete all
                                {{ $assignment->submissions->count() }} student submissions
                                associated with this assignment.
                            </p>
                            <p>This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
