@extends('layouts.admin-absensi')

@section('title','Manajemen Akun')

@section('content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                <i class="bi bi-people"></i> Manajemen Akun
            </h4>

            <small class="text-muted">
                Kelola akun magang dan pegawai
            </small>
        </div>

        <a href="{{ route('absensi.admin.users.create') }}"
           class="btn btn-danger">

            <i class="bi bi-plus-circle me-1"></i> Tambah Akun

        </a>

    </div>


    <!-- CARD TABLE -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th style="width:25%">Nama</th>
                            <th style="width:30%">Email</th>
                            <th style="width:15%">Role</th>
                            <th style="width:15%">Tipe Kerja</th>
                            <th style="width:15%" class="text-center">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                        <tr>

                            <td class="fw-semibold">
                                {{ $user->name }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                @if($user->role == 'magang')

                                    <span class="badge bg-warning text-dark">
                                        Magang
                                    </span>

                                @elseif($user->role == 'pegawai')

                                    <span class="badge bg-primary">
                                        Pegawai
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ ucfirst($user->role) }}
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $user->tipe_kerja ?? '-' }}
                            </td>

                            <td class="text-center">

                                <div class="d-inline-flex gap-1">

                                    <!-- EDIT -->
                                    <a href="{{ route('absensi.admin.users.edit',$user->id) }}"
                                       class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-pencil"></i>

                                    </a>

                                    <!-- DELETE -->
                                    <form action="{{ route('absensi.admin.users.destroy',$user->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus akun ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5 text-muted">

                                <i class="bi bi-inbox fs-3"></i>

                                <div class="mt-2">
                                    Belum ada data akun
                                </div>

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