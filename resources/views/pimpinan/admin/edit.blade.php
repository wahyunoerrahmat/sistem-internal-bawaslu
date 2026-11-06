@extends('layouts.pimpinan')

@section('title', 'Edit Admin')

@section('content')
<div class="title">Edit Admin</div>

<div class="card" style="text-align:left;">
    <form action="{{ route('pimpinan.admin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label>Nama</label>
            <input type="text" name="name" class="input"
                   value="{{ $admin->name }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label>Email</label>
            <input type="email" name="email" class="input"
                   value="{{ $admin->email }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label>Password (kosongkan jika tidak diubah)</label>
            <div style="position:relative;">
                <input type="password"
                       name="password"
                       id="password"
                       class="input"
                       style="padding-right:40px;">

                <span onclick="togglePassword()"
                      style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                             cursor:pointer; font-size:18px;">
                    👁
                </span>
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label>Role</label>
            <select name="role" class="input" required>
                <option value="admin_absensi"
                    {{ $admin->role == 'admin_absensi' ? 'selected' : '' }}>
                    Admin Absensi
                </option>
                <option value="admin_barang"
                    {{ $admin->role == 'admin_barang' ? 'selected' : '' }}>
                    Admin Barang
                </option>
            </select>
        </div>

        <button type="submit" class="btn">Update</button>
        <a href="{{ route('pimpinan.admin.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
