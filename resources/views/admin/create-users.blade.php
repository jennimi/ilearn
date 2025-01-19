@extends('layouts.app')

@section('content')
    <div class="container">

        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning me-2"><i
                    class="bi bi-arrow-left tw-me-2 tw-fs-4 tw-group-hover:tw-text-blue-500"></i>
                <span class="tw-group-hover:tw-underline">Kembali</span></a>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Buat Pengguna</h1>
                <div>
                    <button type="button" class="btn btn-success" id="addRow" disabled>Tambah Baris</button>
                    <button type="submit" class="btn btn-primary" disabled id="submitButton">Buat Pengguna</button>
                </div>
            </div>
            @csrf
            <div class="mb-3">
                <label for="role" class="form-label">Pilih Peran</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">-- Pilih Peran --</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Guru</option>
                    <option value="student">Siswa</option>
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
            admin: ['Nama', 'Email'],
            teacher: ['Nama', 'Email', 'Nomor Telepon', 'Tanggal Lahir'],
            student: ['Nama', 'Email', 'NIK', 'Nomor Telepon', 'Tanggal Lahir', 'Alamat', 'Tanggal Pendaftaran']
        };

        function addRow() {
            const role = roleSelect.value;
            const rowCount = tableBody.rows.length;
            const newRow = document.createElement('tr');

            columns[role].forEach((column) => {
                const cell = document.createElement('td');
                const input = document.createElement('input');
                input.type = (column === 'Tanggal Lahir' || column === 'Tanggal Pendaftaran') ? 'date' : 'text';
                input.name = `users[${rowCount}][${column.toLowerCase().replace(/ /g, '_')}]`;
                input.classList.add('form-control');

                if (['Nama', 'Email', 'NIK'].includes(column)) {
                    input.required = true;
                }

                if (column === 'Nama') {
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
            removeButton.textContent = 'Hapus';
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
                passwordTh.textContent = 'Kata Sandi';
                tableHead.appendChild(passwordTh);

                const actionTh = document.createElement('th');
                actionTh.textContent = 'Aksi';
                tableHead.appendChild(actionTh);
            } else {
                addRowButton.disabled = true;
                submitButton.disabled = true;
            }
        });

        addRowButton.addEventListener('click', addRow);
    </script>
@endsection
