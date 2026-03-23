<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | STY Barber</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .field {
            position: relative;
        }

        .field input {
            width: 100%;
            border: 1px solid #e5e7eb;
            padding: 16px 14px;
            border-radius: 10px;
            font-size: 14px;
            background: white;
        }

        .field label {
            position: absolute;
            left: 14px;
            top: 14px;
            font-size: 13px;
            color: #6b7280;
            transition: .2s;
            background: white;
            padding: 0 4px;
        }

        .field input:focus+label,
        .field input:not(:placeholder-shown)+label {
            top: -8px;
            font-size: 11px;
            color: #2563eb;
        }

        .field input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
        }

        .btn {
            background: #111827;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: .2s;
            display: block;
            text-align: center;
        }

        .btn:hover {
            background: #2563eb;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <img src="{{ asset('gambar/setyo1.jpg') }}" class="w-16 h-16 rounded-xl mx-auto shadow mb-5">
            <h1 class="text-3xl font-bold text-gray-900">Forgot Password</h1>
            <p class="text-gray-500 text-sm mt-1">
                Masukkan email terdaftar untuk menerima link reset password.
            </p>
        </div>

        <div class="card p-6">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-600 text-sm p-4 rounded-lg mb-4 text-center font-medium">
                    {{ session('status') }}
                </div>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn">Kembali ke Login</a>
                </div>
            @else
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div class="field">
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder=" ">
                        <label>Email Address</label>
                        
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn">
                        Kirim Link Reset
                    </button>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline font-medium">
                            Kembali ke Login
                        </a>
                    </div>
                </form>
            @endif
        </div>

        <p class="text-center text-sm text-gray-500 mt-8">
            Butuh bantuan? <a href="https://wa.me/085641728429" class="text-blue-600 font-medium">Hubungi Admin</a>
        </p>

    </div>

</body>

</html>


