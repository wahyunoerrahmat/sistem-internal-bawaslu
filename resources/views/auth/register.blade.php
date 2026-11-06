<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Internal Bawaslu Kabupaten Bogor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #e9e9e9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 380px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-box h2 {
            color: #c40000;
            margin-bottom: 10px;
        }

        .login-box img {
            width: 120px;
            margin: 10px 0;
        }

        .login-box p {
            font-size: 13px;
            margin-bottom: 25px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
            position: relative;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 38px;
            cursor: pointer;
            font-size: 18px;
        }

        .btn-login {
            width: 100%;
            background: #c40000;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #a80000;
        }

        .register-link {
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #c40000;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Sistem Internal</h2>

    <img src="{{ asset('images/logo-bawaslu.png') }}" alt="Logo Bawaslu">

    <p>
        Bersama Rakyat Awasi Pemilu,<br>
        Bersama Bawaslu Tegakkan Keadilan Pemilu
    </p>

    <!-- Error Message -->
    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" required autofocus>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="password" required>
            <span class="toggle-password" onclick="togglePassword()">👁</span>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <span class="toggle-password" onclick="toggleConfirmPassword()">👁</span>
        </div>

        <button type="submit" class="btn-login">
            Daftar
        </button>
    </form>

    <div class="register-link">
        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
    </div>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById("password");
        password.type = password.type === "password" ? "text" : "password";
    }

    function toggleConfirmPassword() {
        const password = document.getElementById("password_confirmation");
        password.type = password.type === "password" ? "text" : "password";
    }
</script>

</body>
</html>
