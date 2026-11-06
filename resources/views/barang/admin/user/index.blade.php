@extends('layouts.admin-barang')

@section('title','Manajemen Pegawai')

@section('content')

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="fw-bold text-danger mb-0">
            <i class="bi bi-people"></i> Manajemen Pegawai
        </h4>
        <small class="text-muted">
            Kelola akun pegawai sistem internal
        </small>
    </div>

    <a href="{{ route('barang.admin.user.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle me-1"></i> Tambah Pegawai
    </a>

</div>


<!-- CARD TABLE -->
<div class="card shadow-sm border-0">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th width="60">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $index => $user)

                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td class="fw-semibold">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ $user->name }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td class="text-center">

                            <!-- EDIT -->
                            <a href="{{ route('barang.admin.user.edit',$user->id) }}"
                               class="btn btn-sm btn-outline-warning me-1">

                               <i class="bi bi-pencil"></i>
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('barang.admin.user.destroy',$user->id) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus pegawai ini?')">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center py-4 text-muted">

                            <i class="bi bi-inbox fs-4"></i>

                            <div class="mt-2">
                                Belum ada data pegawai
                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
