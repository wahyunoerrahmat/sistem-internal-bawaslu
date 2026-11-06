@extends('layouts.admin-absensi')

@section('title', 'Tambah Akun')

@section('content')

<div class="container-fluid py-4">

<div class="title mb-3">
<i class="bi bi-person-plus"></i> Tambah Akun
</div>

<div class="card shadow-sm border-0">

<div class="card-body">

<form action="{{ route('absensi.admin.users.store') }}" method="POST">
@csrf


<!-- NAMA -->

<div class="mb-3">
<label class="form-label fw-semibold">Nama</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-person"></i>
</span>

<input type="text"
name="name"
class="form-control"
placeholder="Masukkan nama lengkap"
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

<input type="email"
name="email"
class="form-control"
placeholder="Masukkan email"
required>

</div>

</div>



<!-- PASSWORD -->

<div class="mb-3">

<label class="form-label fw-semibold">Password</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-lock"></i>
</span>

<input type="password"
name="password"
class="form-control"
id="password"
placeholder="Masukkan password"
required>

<button type="button"
class="btn btn-outline-secondary"
onclick="togglePassword()">

<i class="bi bi-eye"></i>

</button>

</div>

</div>



<!-- ROLE -->

<div class="mb-4">

<label class="form-label fw-semibold">Role</label>

<select name="role" class="form-select" required>

<option value="">-- Pilih Role --</option>
<option value="magang">Magang</option>

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

<i class="bi bi-save"></i> Simpan

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

const password = document.getElementById("password");

if(password.type === "password"){
password.type = "text";
}else{
password.type = "password";
}

}

</script>

@endsection