@extends('layouts.pimpinan')

@section('title', 'Kelola Admin')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-danger mb-0">
            <i class="bi bi-people-fill"></i> Kelola Admin
        </h4>

        <a href="{{ route('pimpinan.admin.create') }}" 
           class="btn btn-danger">
            <i class="bi bi-plus-circle"></i> Tambah Admin
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center" width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($admins as $admin)
                        <tr>
                            <td class="fw-semibold">
                                {{ $admin->name }}
                            </td>

                            <td>
                                {{ $admin->email }}
                            </td>

                            <td>
                                @if($admin->role === 'admin_absensi')
                                    <span class="badge bg-primary">
                                        Admin Absensi
                                    </span>
                                @elseif($admin->role === 'admin_barang')
                                    <span class="badge bg-success">
                                        Admin Barang
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst(str_replace('_',' ',$admin->role)) }}
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">

                                <a href="{{ route('pimpinan.admin.edit', $admin->id) }}"
                                   class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('pimpinan.admin.destroy', $admin->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle"></i> 
                                Belum ada data admin.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection