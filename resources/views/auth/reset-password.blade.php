<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | STY Barber</title>

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

        /* Khusus untuk email yang readonly */
        .field input:read-only {
            background: #f1f5f9;
            color: #64748b;
            cursor: not-allowed;
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

        /* Label floating effect */
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
            text-align: center;
        }

        .btn:hover {
            background: #2563eb;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            cursor: pointer;
            color: #6b7280;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <img src="{{ asset('gambar/setyo1.jpg') }}" class="w-16 h-16 rounded-xl mx-auto shadow mb-5">
            <h1 class="text-3xl font-bold text-gray-900">Set New Password</h1>
            <p class="text-gray-500 text-sm mt-1">
                Silakan buat password baru untuk akun Anda.
            </p>
        </div>

        <div class="card p-6">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="field">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly placeholder=" ">
                    <label>Email Address</label>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field relative">
                    <input id="password" type="password" name="password" required autofocus placeholder=" ">
                    <label>New Password</label>
                    <span class="toggle-password" onclick="toggleVisibility('password')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder=" ">
                    <label>Confirm Password</label>
                    <span class="toggle-password" onclick="toggleVisibility('password_confirmation')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                </div>

                <button type="submit" class="btn mt-2">
                    Update Password
                </button>
            </form>
        </div>

    </div>

    <script>
        function toggleVisibility(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>

</html>