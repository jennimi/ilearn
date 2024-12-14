@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="tw-group tw-hover:tw-text-blue-500 tw-hover:tw-underline">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-link tw-text-black tw-text-decoration-none tw-d-flex tw-align-items-center">
                <i class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Back</span>
            </a>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Create Users</h1>
                <div>
                    <button type="button" class="btn btn-success" id="addRow" disabled>Add Row</button>
                    <button type="submit" class="btn btn-primary" disabled id="submitButton">Create Users</button>
                </div>
            </div>
            @csrf
            <div class="mb-3">
                <label for="role" class="form-label">Select Role</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <table class="table" id="userTable">
                <thead>
                    <tr id="tableHead"></tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>

        </form>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
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



    </div>

    <script>
        const tableHead = document.getElementById('tableHead');
        const tableBody = document.getElementById('tableBody');
        const roleSelect = document.getElementById('role');
        const addRowButton = document.getElementById('addRow');
        const submitButton = document.getElementById('submitButton');

        const columns = {
            admin: ['Name', 'Email'],
            teacher: ['Name', 'Email', 'Phone Number', 'Date of Birth'],
            student: ['Name', 'Email', 'NIK', 'Phone Number', 'Date of Birth', 'Address', 'Enrollment Date']
        };

        function addRow() {
            const role = roleSelect.value;
            const rowCount = tableBody.rows.length;
            const newRow = document.createElement('tr');

            columns[role].forEach((column) => {
                const cell = document.createElement('td');
                const input = document.createElement('input');
                input.type = (column === 'Date of Birth' || column === 'Enrollment Date') ? 'date' : 'text';
                input.name = `users[${rowCount}][${column.toLowerCase().replace(/ /g, '_')}]`;
                input.classList.add('form-control');

                if (['Name', 'Email', 'NIK'].includes(column)) {
                    input.required = true;
                }

                if (column === 'Name') {
                    input.addEventListener('blur', (e) => {
                        const passwordField = document.querySelector(
                            `input[name="users[${rowCount}][password_display]"]`
                        );
                        passwordField.value = e.target.value + '123';
                        passwordField.dataset.generated = e.target.value + '123';
                    });
                }

                if (column === 'NIK' && role === 'student') {
                    input.addEventListener('blur', (e) => {
                        const passwordField = document.querySelector(
                            `input[name="users[${rowCount}][password_display]"]`
                        );
                        passwordField.value = e.target.value;
                        passwordField.dataset.generated = e.target.value;
                    });
                }

                cell.appendChild(input);
                newRow.appendChild(cell);
            });

            const passwordCell = document.createElement('td');
            const passwordDisplayInput = document.createElement('input');
            passwordDisplayInput.type = 'text';
            passwordDisplayInput.name = `users[${rowCount}][password_display]`;
            passwordDisplayInput.classList.add('form-control');
            passwordDisplayInput.readOnly = true;
            passwordCell.appendChild(passwordDisplayInput);
            newRow.appendChild(passwordCell);

            const passwordHiddenInput = document.createElement('input');
            passwordHiddenInput.type = 'hidden';
            passwordHiddenInput.name = `users[${rowCount}][password]`;
            passwordDisplayInput.addEventListener('input', () => {
                passwordHiddenInput.value = passwordDisplayInput.dataset.generated;
            });
            passwordCell.appendChild(passwordHiddenInput);

            const removeCell = document.createElement('td');
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn', 'btn-danger', 'removeRow');
            removeButton.textContent = 'Remove';
            removeButton.addEventListener('click', () => newRow.remove());
            removeCell.appendChild(removeButton);
            newRow.appendChild(removeCell);

            tableBody.appendChild(newRow);
        }

        roleSelect.addEventListener('change', () => {
            const role = roleSelect.value;

            tableHead.innerHTML = '';
            tableBody.innerHTML = '';

            if (role && columns[role]) {
                addRowButton.disabled = false;
                submitButton.disabled = false;

                columns[role].forEach(column => {
                    const th = document.createElement('th');
                    th.textContent = column;
                    tableHead.appendChild(th);
                });

                const passwordTh = document.createElement('th');
                passwordTh.textContent = 'Password';
                tableHead.appendChild(passwordTh);

                const actionTh = document.createElement('th');
                actionTh.textContent = 'Action';
                tableHead.appendChild(actionTh);
            } else {
                addRowButton.disabled = true;
                submitButton.disabled = true;
            }
        });

        addRowButton.addEventListener('click', addRow);
    </script>
@endsection
