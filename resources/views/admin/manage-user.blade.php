@extends('layout.master')

@section('title')
    Manage User
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Manage User</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Users</h4>
                        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            Add User
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Bergabung Pada</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateUserModal{{ $user->id }}">Update</button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal{{ $user->id }}">Delete</button>
                                        </td>
                                    </tr>
                                    <!-- Update User Modal -->
                                    <div class="modal fade" id="updateUserModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="updateUserModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateUserModalLabel{{ $user->id }}">
                                                        Update User
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/admin/{{ $user->id }}/update" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Nama -->
                                                        <div class="mb-3">
                                                            <label for="name{{ $user->id }}"
                                                                class="form-label">Name</label>
                                                            <input type="text" class="form-control"
                                                                id="name{{ $user->id }}" name="name"
                                                                value="{{ $user->name }}" required>
                                                        </div>

                                                        <!-- Username -->
                                                        <div class="mb-3">
                                                            <label for="username{{ $user->id }}"
                                                                class="form-label">Username</label>
                                                            <input type="text" class="form-control"
                                                                id="username{{ $user->id }}" name="username"
                                                                value="{{ $user->username }}" required>
                                                        </div>

                                                        <!-- Alamat -->
                                                        <div class="mb-3">
                                                            <label for="alamat{{ $user->id }}"
                                                                class="form-label">Alamat</label>
                                                            <textarea class="form-control" id="alamat{{ $user->id }}" name="alamat" rows="3" required>{{ $user->alamat }}</textarea>
                                                        </div>

                                                        <!-- Password -->
                                                        <div class="mb-3">
                                                            <label for="password{{ $user->id }}"
                                                                class="form-label">Password</label>
                                                            <input type="password" class="form-control"
                                                                id="password{{ $user->id }}" name="password">
                                                            <small class="form-text text-muted">* kosongkan jika tidak ingin
                                                                mengganti password.</small>
                                                        </div>

                                                        <!-- Role -->
                                                        <div class="mb-3">
                                                            <label for="role{{ $user->id }}"
                                                                class="form-label">Role</label>
                                                            <select class="form-control" id="role{{ $user->id }}"
                                                                name="role" required>
                                                                <option value="admin"
                                                                    {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="user"
                                                                    {{ $user->role == 'user' ? 'selected' : '' }}>User
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <!-- Avatar -->
                                                        <div class="mb-3">
                                                            <label for="avatar{{ $user->id }}"
                                                                class="form-label">Avatar</label>
                                                            <input type="file" class="form-control"
                                                                id="avatar{{ $user->id }}" name="avatar">
                                                            <small class="form-text text-muted">*Kosongkan jika tidak ingin
                                                                mengubah gambar.</small><br>
                                                            @if ($user->avatar != '')
                                                                <a href="{{ Storage::url('uploads/' . $user->avatar) }}"
                                                                    target="_blank">Lihat avatar saat ini</a>
                                                            @endif
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete User Modal -->
                                    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">
                                                        Delete User
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this user?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="/admin/{{ $user->id }}/delete" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/store-new-user" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <!-- Avatar -->
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                        </div>

                        <!-- Keterangan -->
                        <div class="form-text mt-2">
                            * Password defaultnya akan sama dengan username
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: '{{ $errors->first() }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
