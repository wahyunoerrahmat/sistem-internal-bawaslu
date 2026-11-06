@extends('layouts.admin-absensi')

@section('title', 'Laporan Absensi')

@section('content')

<div class="container-fluid">

```
<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h4 class="fw-bold mb-1">
            <i class="bi bi-clipboard-data"></i> Laporan Absensi
        </h4>

        @if(request('tanggal_mulai') || request('tanggal_akhir') || request('user_id'))

            <small class="text-muted">
                Periode :

                {{ request('tanggal_mulai')
                    ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d M Y')
                    : '-' }}

                —

                {{ request('tanggal_akhir')
                    ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d M Y')
                    : '-' }}

                @if(request('user_id'))
                    | Akun :
                    {{ $users->where('id', request('user_id'))->first()->name ?? '-' }}
                @endif
            </small>

        @endif
    </div>

    <a href="{{ route('absensi.admin.pdf', request()->query()) }}" class="btn btn-danger">
        <i class="bi bi-printer"></i> Print
    </a>

</div>


<!-- FILTER -->
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('absensi.admin.laporan') }}">

            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        class="form-control"
                        value="{{ request('tanggal_mulai') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Pilih Akun</label>

                    <select name="user_id" class="form-select">

                        <option value="">Semua Akun</option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                {{ request('user_id') == $user->id ? 'selected' : '' }}
                            >
                                {{ $user->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('absensi.admin.laporan') }}" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>

</div>


<!-- TABLE -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-table"></i> Data Laporan Absensi
    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Status</th>
                    <th>Foto Masuk</th>
                    <th>Foto Pulang</th>
                </tr>
            </thead>

            <tbody>

                @forelse($data as $key => $row)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td class="fw-semibold">
                            <i class="bi bi-person"></i>
                            {{ $row->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($row->jam_masuk)->format('d M Y') }}
                        </td>

                        <td>
                            @if($row->jam_masuk)

                                <span class="badge bg-success">
                                    {{ $row->jam_masuk }}
                                </span>

                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>
                            @if($row->jam_pulang)

                                <span class="badge bg-primary">
                                    {{ $row->jam_pulang }}
                                </span>

                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td>

                            <span class="badge
                                @if(str_contains($row->status,'hadir')) bg-success
                                @elseif(str_contains($row->status,'izin')) bg-warning text-dark
                                @elseif(str_contains($row->status,'terlambat')) bg-danger
                                @elseif(str_contains($row->status,'pulang')) bg-primary
                                @else bg-secondary
                                @endif
                            ">
                                {{ ucfirst($row->status) }}
                            </span>

                        </td>

                        <td>

                            @if($row->foto_masuk)

                                <a href="{{ asset('storage/'.$row->foto_masuk) }}" target="_blank">

                                    <img
                                        src="{{ asset('storage/'.$row->foto_masuk) }}"
                                        width="55"
                                        class="rounded shadow-sm">

                                </a>

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                        <td>

                            @if($row->foto_pulang)

                                <a href="{{ asset('storage/'.$row->foto_pulang) }}" target="_blank">

                                    <img
                                        src="{{ asset('storage/'.$row->foto_pulang) }}"
                                        width="55"
                                        class="rounded shadow-sm">

                                </a>

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center py-4 text-muted">

                            <i class="bi bi-inbox fs-4"></i>

                            <div class="mt-2">
                                Tidak ada data absensi
                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
```

</div>

@endsection
