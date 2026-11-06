@extends('layouts.resepsionis')

@section('title','Edit Data Tamu')

@section('content')

<div class="container mt-5">

    {{-- LOGO --}}
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo-bawaslu.png') }}"
             width="140">
    </div>


    {{-- DATA TIDAK ADA --}}
    @if(!$tamu)

        <div class="alert alert-danger text-center">
            Data tamu tidak ditemukan.
        </div>

        <div class="text-center">
            <a href="{{ route('resepsionis.tamu') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>

    @else

    {{-- CARD --}}
    <div class="card border-0 rounded-4 p-4 mx-auto form-card">

        <h5 class="text-center fw-bold mb-4">
            Edit Data Tamu
        </h5>

        <form action="{{ route('resepsionis.tamu.update',$tamu->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Nama Lengkap
                </label>

                <div class="col-md-8">
                    <input type="text"
                        name="nama_lengkap"
                        class="form-control form-input"
                        value="{{ old('nama_lengkap',$tamu->nama_lengkap) }}"
                        required>
                </div>
            </div>


            {{-- ALAMAT --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Alamat
                </label>

                <div class="col-md-8">
                    <input type="text"
                        name="alamat"
                        class="form-control form-input"
                        value="{{ old('alamat',$tamu->alamat) }}">
                </div>
            </div>


            {{-- KONTAK --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    No HP / Email
                </label>

                <div class="col-md-8">
                    <input type="text"
                        name="kontak"
                        class="form-control form-input"
                        value="{{ old('kontak',$tamu->kontak) }}">
                </div>
            </div>


            {{-- KEPERLUAN --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Keperluan Kunjungan
                </label>

                <div class="col-md-8">
                    <textarea name="keperluan"
                        class="form-control form-input"
                        rows="3"
                        required>{{ old('keperluan',$tamu->keperluan) }}</textarea>
                </div>
            </div>


            {{-- PEGAWAI DITUJU --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Pihak yang Dituju
                </label>

                <div class="col-md-8">
                    <input type="text"
                        name="pihak_dituju"
                        class="form-control form-input"
                        value="{{ old('pihak_dituju',$tamu->pihak_dituju) }}"
                        required>
                </div>
            </div>


            {{-- PETUGAS PENERIMA --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Nama Penerima
                </label>

                <div class="col-md-8">
                    <input type="text"
                        name="nama_penerima"
                        class="form-control form-input"
                        value="{{ old('nama_penerima',$tamu->nama_penerima) }}"
                        required>
                </div>
            </div>


            {{-- DOKUMENTASI TAMU --}}
            <div class="row mb-4 align-items-center">
                <label class="col-md-4 form-label">
                    Dokumentasi Tamu
                </label>

                <div class="col-md-8">

                    @if($tamu->foto)
                        <img src="{{ asset('storage/'.$tamu->foto) }}"
                             width="120"
                             class="mb-2">
                    @endif

                    <input type="file"
                        name="dokumentasi"
                        class="form-control form-input">
                </div>
            </div>


            {{-- BUTTON --}}
            <div class="text-center d-flex justify-content-center gap-3">

                <button class="btn btn-submit px-4">
                    Update Data
                </button>

                <a href="{{ route('resepsionis.tamu') }}"
                   class="btn btn-secondary px-4">
                    Kembali
                </a>

            </div>

        </form>

    </div>

    @endif

</div>


<style>

body{
    background:#eef1f5;
}

.form-card{
    max-width:720px;
    background:#f7f9fc;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

.form-label{
    font-weight:500;
    color:#333;
}

.form-input{
    border-radius:8px;
    height:42px;
    border:1px solid #dcdfe6;
}

textarea.form-input{
    height:auto;
}

.btn-submit{
    background:#d32f2f;
    color:white;
    border-radius:8px;
    padding:8px 30px;
    font-weight:500;
}

.btn-submit:hover{
    background:#b71c1c;
}

</style>

@endsection 