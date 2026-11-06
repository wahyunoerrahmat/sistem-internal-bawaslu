<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sistem Internal Bawaslu Kabupaten Bogor</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    height:100vh;
    overflow:hidden;
}

/* ===============================
   BACKGROUND IMAGE
=================================*/

.login-bg{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:url("{{ asset('images/bg-bawaslu.png') }}") center center / cover no-repeat;
}

/* Overlay + Blur agar profesional */
.login-bg::after{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background:linear-gradient(
        rgba(0,0,0,0.65),
        rgba(0,0,0,0.35)
    );

    backdrop-filter:blur(4px);
}

/* ===============================
   WRAPPER
=================================*/

.login-wrapper{
    position:relative;
    z-index:10;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

/* ===============================
   LOGIN CARD
=================================*/

.login-box{
    background:white;
    padding:40px;
    border-radius:16px;
    width:400px;
    box-shadow:0 25px 60px rgba(0,0,0,0.35);
    text-align:center;
}

.login-box h2{
    color:#c40000;
    margin-bottom:10px;
}

.login-box img{
    width:120px;
    margin:10px 0;
}

.login-box p{
    font-size:13px;
    margin-bottom:25px;
}

/* ===============================
   FORM
=================================*/

.form-group{
    text-align:left;
    margin-bottom:15px;
    position:relative;
}

.form-group label{
    font-weight:bold;
    margin-bottom:5px;
    display:block;
}

.form-group input{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

/* Toggle Password */

.toggle-password{
    position:absolute;
    right:10px;
    top:38px;
    cursor:pointer;
}

/* ===============================
   BUTTON
=================================*/

.btn-login{
    width:100%;
    background:#c40000;
    color:white;
    padding:12px;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

.btn-login:hover{
    background:#a80000;
}

/* ===============================
   REGISTER LINK
=================================*/

.register-link{
    margin-top:15px;
    font-size:14px;
}

.register-link a{
    color:#c40000;
    font-weight:bold;
    text-decoration:none;
}

/* ===============================
   FOOTER RUNNING TEXT
=================================*/

.login-footer{
    position:fixed;
    bottom:0;
    width:100%;
    height:40px;
    background:transparent;
    overflow:hidden;
    display:flex;
    align-items:center;
}

/* Text berjalan */

.running-text{
    white-space:nowrap;
    color:white;
    font-size:14px;
    padding-left:100%;
    animation:runningText 25s linear infinite;
}

@keyframes runningText{
    from{
        transform:translateX(0);
    }
    to{
        transform:translateX(-100%);
    }
}

</style>
</head>

<body>

<div class="login-bg"></div>

<div class="login-wrapper">

<div class="login-box">

<h2>Sistem Internal</h2>

<img src="{{ asset('images/logo-bawaslu.png') }}">

<p>
Bersama Rakyat Awasi Pemilu,<br>
Bersama Bawaslu Tegakkan Keadilan Pemilu
</p>

@if(session('status'))
<div style="color:green;margin-bottom:10px;">
{{ session('status') }}
</div>
@endif

@if ($errors->any())
<div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; text-align: left;">
    @foreach ($errors->all() as $error)
        <div>⚠️ {{ $error }}</div>
    @endforeach
</div>
@endif

<form method="POST" action="{{ route('login') }}">
@csrf

<div class="form-group">
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required autofocus>
</div>

<div class="form-group">
<label>Password</label>
<input type="password" name="password" id="password" required>
<span class="toggle-password" onclick="togglePassword()">👁</span>
</div>

<button type="submit" class="btn-login">
Log in
</button>

</form>

<div class="register-link">
Belum punya akun?
<a href="{{ route('register') }}">Daftar</a>
</div>

</div>
</div>

<!-- FOOTER BERGERAK -->

<div class="login-footer">
<div class="running-text">
© {{ date('Y') }} Badan Pengawas Pemilihan Umum Kabupaten Bogor
</div>
</div>

<script>

function togglePassword(){
    const pass=document.getElementById("password");
    pass.type = pass.type === "password" ? "text":"password";
}

</script>

</body>
</html>