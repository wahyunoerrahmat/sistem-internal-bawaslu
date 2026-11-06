@extends('layouts.magang')

@section('title', 'Absen Masuk')

@section('content')

<div class="container py-4">
<div class="row justify-content-center">

<div class="col-lg-5 col-md-6">

<div class="card shadow-lg border-0">

<div class="card-header bg-danger text-white text-center py-3">
<h5 class="mb-0">
<i class="bi bi-camera"></i> Absensi Masuk
</h5>
</div>

<div class="card-body text-center">

{{-- ALERT --}}
@if(session('error'))

<div class="alert alert-danger">
{{ session('error') }}
</div>
@endif

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<!-- CAMERA FRAME -->

<div class="camera-box mb-3">

<video id="video" autoplay playsinline></video>

<div class="camera-overlay">
<i class="bi bi-camera-video-off"></i>
</div>

</div>

<canvas id="canvas" style="display:none;"></canvas>

<form method="POST" action="{{ route('absensi.magang.masuk.store') }}">
@csrf

<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">
<input type="hidden" name="foto" id="foto">

<!-- BUTTON -->

<div class="d-grid gap-2">

<button type="button" class="btn btn-outline-primary" onclick="takePhoto()">
<i class="bi bi-camera"></i> Ambil Foto
</button>

<button type="submit" class="btn btn-danger btn-lg">
<i class="bi bi-check-circle"></i> Absen Sekarang
</button>

</div>

</form>

</div>

</div>

</div>

</div>
</div>

@endsection

@section('styles')

<style>

.camera-box{
position:relative;
width:100%;
height:280px;
background:#1b1f3b;
border-radius:10px;
overflow:hidden;
display:flex;
align-items:center;
justify-content:center;
}

#video{
width:100%;
height:100%;
object-fit:cover;
}

.camera-overlay{
position:absolute;
font-size:60px;
color:white;
opacity:0.4;
}

.card{
border-radius:12px;
}

</style>

@endsection

@section('scripts')

<script>

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

let currentLat = null;
let currentLng = null;


/* ==========================
   AKTIFKAN KAMERA
========================== */

navigator.mediaDevices.getUserMedia({
video: { facingMode: "user" }
})
.then(stream => {
video.srcObject = stream;
})
.catch(() => {
alert("Kamera tidak dapat diakses.");
});


/* ==========================
   AMBIL FOTO
========================== */

function takePhoto(){

canvas.width = video.videoWidth;
canvas.height = video.videoHeight;

const ctx = canvas.getContext('2d');
ctx.drawImage(video,0,0);

const dataUrl = canvas.toDataURL('image/jpg');

document.getElementById('foto').value = dataUrl;

alert("Foto berhasil diambil");

}


/* ==========================
   VALIDASI SUBMIT
========================== */

document.querySelector("form").addEventListener("submit",function(e){

if(!document.getElementById("foto").value){

alert("Silakan ambil foto terlebih dahulu.");

e.preventDefault();

}

});

</script>

@endsection
