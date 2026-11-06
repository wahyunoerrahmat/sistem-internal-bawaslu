@extends('layouts.pimpinan')

@section('title', 'Absen WFO Pulang')

@section('content')
<h2 class="title">Absen WFO Pulang</h2>

<div class="card" style="text-align:center;">
    <!-- Preview kamera -->
    <video id="video" autoplay playsinline width="280"
        style="border-radius:10px; margin-bottom:15px;">
    </video>

    <canvas id="canvas" style="display:none;"></canvas>

    <form method="POST" action="{{ route('absensi.pegawai.pulang.store') }}">
        @csrf

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="foto" id="foto">

        <div style="margin-bottom:10px;">
            <button type="button" class="btn" onclick="takePhoto()">
                Ambil Foto
            </button>
        </div>

        <button type="submit" class="btn">
            Absen WFO Pulang
        </button>
    </form>
</div>

<script>
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');

let currentLat = null;
let currentLng = null;

// =============================
// AKTIFKAN KAMERA
// =============================
navigator.mediaDevices.getUserMedia({
    video: { facingMode: "user" }
})
.then(stream => {
    video.srcObject = stream;
})
.catch(err => {
    alert("Kamera tidak dapat diakses.");
});

// =============================
// AMBIL FOTO
// =============================
function takePhoto() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    const dataUrl = canvas.toDataURL('image/jpeg');
    document.getElementById('foto').value = dataUrl;

    alert("Foto berhasil diambil");
}

// =============================
// AMBIL LOKASI
// =============================
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            currentLat = position.coords.latitude;
            currentLng = position.coords.longitude;

            document.getElementById('latitude').value = currentLat;
            document.getElementById('longitude').value = currentLng;
        }, function() {
            alert("Gagal mengambil lokasi. Aktifkan GPS.");
        });
    } else {
        alert("Browser tidak mendukung GPS.");
    }
}

// =============================
// TRACKING LIVE
// =============================
function startTracking() {
    setInterval(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                currentLat = position.coords.latitude;
                currentLng = position.coords.longitude;

                fetch("{{ route('absensi.admin.map') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        lat: currentLat,
                        lng: currentLng
                    })
                });
            });
        }
    }, 5000);
}

getLocation();
startTracking();
</script>
@endsection
