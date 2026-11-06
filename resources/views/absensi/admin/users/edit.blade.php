@extends('layouts.admin-absensi')

@section('title', 'Edit Akun')

@section('content')

<div class="container-fluid py-4">

    <div class="title mb-3">
        <i class="bi bi-pencil-square"></i> Edit Akun
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="{{ route('absensi.admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- NAMA -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">Nama</label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ $user->name }}"
                            required>

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">Email</label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ $user->email }}"
                            required>

                    </div>

                </div>


                <!-- PASSWORD BARU -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Password Baru
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengganti password">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword()">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti password
                    </small>

                </div>


                <!-- ROLE -->

                <div class="mb-4">

                    <label class="form-label fw-semibold">Role</label>

                    <select name="role" class="form-select" required>

                        <option value="magang"
                            {{ $user->role == 'magang' ? 'selected' : '' }}>
                            Magang
                        </option>

                        <option value="pegawai"
                            {{ $user->role == 'pegawai' ? 'selected' : '' }}>
                            Pegawai
                        </option>

                    </select>

                </div>


                <!-- BUTTON -->

                <div class="d-flex justify-content-between">

                    <a href="{{ route('absensi.admin.users.index') }}"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i> Kembali

                    </a>

                    <button type="submit"
                            class="btn btn-danger">

                        <i class="bi bi-save"></i> Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>

function togglePassword(){

    const input = document.getElementById("password");

    if(input.type === "password"){
        input.type = "text";
    }else{
        input.type = "password";
    }

}

</script>

@endsection