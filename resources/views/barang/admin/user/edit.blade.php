@extends('layouts.admin-barang')

@section('title','Edit Pegawai')

@section('content')

<div class="container-fluid">

<!-- HEADER -->
<div class="mb-4">
    <h4 class="fw-bold text-danger mb-1">
        <i class="bi bi-pencil-square"></i> Edit Pegawai
    </h4>
    <small class="text-muted">
        Perbarui informasi akun pegawai
    </small>
</div>


<!-- CARD FORM -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-person-gear"></i> Form Edit Pegawai
    </div>

    <div class="card-body">

        <form action="{{ route('barang.admin.user.update',$user->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- NAMA -->
                <div class="col-md-12">

                    <label class="form-label fw-semibold">
                        Nama
                    </label>

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
                <div class="col-md-12">

                    <label class="form-label fw-semibold">
                        Email
                    </label>

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


                <!-- PASSWORD -->
                <div class="col-md-12">

                    <label class="form-label fw-semibold">
                        Password <span class="text-muted">(Opsional)</span>
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

                </div>

            </div>


            <!-- BUTTON -->
            <div class="mt-4">

                <button class="btn btn-danger">
                    <i class="bi bi-save"></i> Update
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
