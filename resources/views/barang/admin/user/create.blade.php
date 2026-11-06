@extends('layouts.admin-barang')

@section('title','Tambah Pegawai')

@section('content')

<div class="container-fluid">

<!-- HEADER -->
<div class="mb-4">
    <h4 class="fw-bold text-danger mb-1">
        <i class="bi bi-person-plus"></i> Tambah Pegawai
    </h4>
    <small class="text-muted">
        Tambahkan akun pegawai baru ke dalam sistem
    </small>
</div>


<!-- FORM CARD -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-pencil-square"></i> Form Data Pegawai
    </div>

    <div class="card-body">

        <form action="{{ route('barang.admin.user.store') }}" method="POST">

            @csrf

            <div class="row g-3">

                <!-- NAMA -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Nama</label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Masukkan nama pegawai"
                            required>
                    </div>
                </div>


                <!-- EMAIL -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Email</label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Masukkan email pegawai"
                            required>
                    </div>
                </div>


                <!-- PASSWORD -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Password</label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Masukkan password">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePassword()">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                </div>

            </div>


            <!-- BUTTON -->
            <div class="mt-4">

                <button class="btn btn-danger">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="{{ route('barang.admin.user.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>

            </div>

        </form>

    </div>

</div>

</div>

<script>

function togglePassword() {

    const password = document.getElementById("password");

    if(password.type === "password"){
        password.type = "text";
    }else{
        password.type = "password";
    }

}

</script>

@endsection
