@extends('layouts.magang')

@section('title', 'Riwayat Absensi')

@section('content')

<div class="container py-4">

    <div class="title mb-3">
        <i class="bi bi-clock-history"></i> Riwayat Absensi
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            @if($data->count() == 0)

                <div class="text-center py-5">

                    <i class="bi bi-calendar-x fs-1 text-muted"></i>

                    <p class="text-muted mt-3">
                        Belum ada riwayat absensi
                    </p>

                </div>

            @else

                <div class="table-responsive">

                    <table class="table table-striped align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Foto Masuk</th>
                                <th>Foto Pulang</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($data as $row)

                                <tr>

                                    <td>
                                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                    </td>

                                    <td>
                                        {{ $row->jam_masuk ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $row->jam_pulang ?? '-' }}
                                    </td>

                                    <td>

                                        @if($row->status == 'masuk')

                                            <span class="badge bg-success">
                                                Masuk
                                            </span>

                                        @elseif($row->status == 'terlambat')

                                            <span class="badge bg-warning text-dark">
                                                Terlambat
                                            </span>

                                        @elseif($row->status == 'pulang')

                                            <span class="badge bg-primary">
                                                Pulang
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($row->foto_masuk)

                                            <img
                                                src="{{ asset('storage/'.$row->foto_masuk) }}"
                                                width="60"
                                                class="rounded shadow-sm">

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td>

                                        @if($row->foto_pulang)

                                            <img
                                                src="{{ asset('storage/'.$row->foto_pulang) }}"
                                                width="60"
                                                class="rounded shadow-sm">

                                        @else

                                            -

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection