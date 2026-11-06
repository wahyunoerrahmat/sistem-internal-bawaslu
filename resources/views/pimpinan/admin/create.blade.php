@extends('layouts.pimpinan')

@section('title', 'Tambah Admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-bold text-danger mb-1">
            <i class="bi bi-person-plus-fill"></i> Tambah Admin
        </h4>
        <p class="text-muted mb-0">
            Tambahkan admin baru untuk sistem internal.
        </p>
    </div>

    <!-- Card Form -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="{{ route('pimpinan.admin.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    <!-- Nama -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Masukkan email"
                               required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password"
                                   required>

                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword()">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="role"
                                class="form-select @error('role') is-invalid @enderror"
                                required>

                            <option value="">-- Pilih Role --</option>

                            <option value="admin_absensi"
                                {{ old('role') == 'admin_absensi' ? 'selected' : '' }}>
                                Admin Absensi
                            </option>

                            <option value="admin_barang"
                                {{ old('role') == 'admin_barang' ? 'selected' : '' }}>
                                Admin Barang
                            </option>

                            <option value="resepsionis"
                                {{ old('role') == 'resepsionis' ? 'selected' : '' }}>
                                Resepsionis
                            </option>
                        </select>

                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="{{ route('pimpinan.admin.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection


@section('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection