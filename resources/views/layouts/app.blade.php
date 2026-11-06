<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
        }

        .navbar {
            background: #c40000;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            padding: 20px;
        }

        .logout-btn {
            background: white;
            color: #c40000;
            border: none;
            padding: 8px 12px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div>
            <strong>Sistem Internal Bawaslu</strong>
        </div>

        <div>
            {{ auth()->user()->name ?? '' }}

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button class="logout-btn" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="container">
        {{ $slot ?? '' }}
        @yield('content')
    </div>

</body>
</html>
