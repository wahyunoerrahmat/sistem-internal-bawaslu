@extends('layouts.resepsionis')

@section('title','Input Tamu')

@section('content')

<div class="container mt-5">

    {{-- LOGO --}}
    <div class="text-center mb-4">
        <img src="{{ asset('images/logo-bawaslu.png') }}"
             width="140"
             class="img-fluid">
    </div>


    {{-- CARD FORM --}}
    <div class="card border-0 rounded-4 p-4 mx-auto form-card">

        <h5 class="text-center fw-bold mb-4 text-danger">
            Pendaftaran Tamu
        </h5>

        <form action="{{ route('resepsionis.tamu.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- NAMA --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">Nama Lengkap</label>
                <div class="col-md-8">
                    <input type="text"
                           name="nama_lengkap"
                           class="form-control form-input"
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
                           required>
                </div>
            </div>

            {{-- NO HP / EMAIL --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    No HP / Email
                </label>

                <div class="col-md-8">
                    <input type="text"
                           name="kontak"
                           class="form-control form-input">
                </div>
            </div>

            {{-- KEPERLUAN --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Keperluan Kunjungan
                </label>

                <div class="col-md-8">
                    <input type="text"
                           name="keperluan"
                           class="form-control form-input"
                           required>
                </div>
            </div>

            {{-- PIHAK YANG DITUJU --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Pihak yang Dituju
                </label>

                <div class="col-md-8">
                    <input type="text"
                           name="pihak_dituju"
                           class="form-control form-input"
                           required>
                </div>
            </div>

            {{-- NAMA PENERIMA --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Nama Penerima
                </label>

                <div class="col-md-8">
                    <input type="text"
                           name="nama_penerima"
                           class="form-control form-input"
                           required>
                </div>
            </div>

            {{-- DOKUMENTASI TAMU --}}
            <div class="row mb-3 align-items-center">
                <label class="col-md-4 form-label">
                    Dokumentasi Tamu
                </label>

                <div class="col-md-8">
                    <input type="file"
                           name="dokumentasi"
                           class="form-control form-input"
                           accept="image/*"
                           required>

                    <small class="text-muted">
                        Upload foto tamu (jpg/png max 2MB)
                    </small>
                </div>
            </div>

            {{-- AUTO WAKTU --}}
            <input type="hidden"
                   name="waktu_datang"
                   id="tanggal">


            <div class="text-center mt-4">
                <button type="submit"
                        class="btn btn-submit px-4">
                    <i class="fa fa-save me-1"></i>
                    Simpan Data
                </button>
            </div>

        </form>

    </div>

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

.form-input:focus{
    border-color:#dc3545;
    box-shadow:0 0 0 0.15rem rgba(220,53,69,.25);
}

.btn-submit{
    background:#dc3545;
    color:white;
    border-radius:8px;
    padding:8px 30px;
    font-weight:500;
}

.btn-submit:hover{
    background:#b02a37;
}

</style>


<script>
const tanggalInput = document.getElementById('tanggal');

if(tanggalInput){
    const now = new Date();

    const formatted =
        now.getFullYear()+"-"+ 
        String(now.getMonth()+1).padStart(2,'0')+"-"+ 
        String(now.getDate()).padStart(2,'0')+" "+
        String(now.getHours()).padStart(2,'0')+":"+
        String(now.getMinutes()).padStart(2,'0')+":"+
        String(now.getSeconds()).padStart(2,'0');

    tanggalInput.value = formatted;
}
</script>

@endsection