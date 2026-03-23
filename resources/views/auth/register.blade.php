<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | STY Barber</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }

        /* card */

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        /* floating input */

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

        /* password */

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 44px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            cursor: pointer;
            color: #6b7280;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        /* otp */

        .otp {
            display: flex;
            gap: 8px;
            justify-content: space-between;
        }

        .otp input {
            width: 48px;
            height: 52px;
            text-align: center;
            font-size: 20px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .otp input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .15);
        }

        /* button */

        .btn {
            background: #111827;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: .2s;
        }

        .btn:hover {
            background: #2563eb;
        }

        /* spinner */

        .spinner {
            border: 2px solid rgba(255, 255, 255, .3);
            border-top: 2px solid white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        /* toast */

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #111827;
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            opacity: 0;
            transform: translateY(-10px);
            transition: .3s;
            z-index: 100;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* progress */

        .progress {
            height: 6px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background: #2563eb;
            transition: .4s;
        }

        /* responsive */

        @media(max-width:640px) {

            .otp input {
                width: 40px;
                height: 48px;
                font-size: 18px;
            }

            #sendOtpBtn {
                font-size: 12px;
                padding: 0 10px;
            }

        }
    </style>

</head>

<body class="min-h-screen flex items-center justify-center px-4 py-10">

    <div id="toast" class="toast"></div>

    <div class="w-full max-w-md">

        <div class="text-center mb-8">

            <img src="{{ asset('gambar/setyo1.jpg') }}" class="w-16 h-16 rounded-xl mx-auto shadow mb-5">

            <h1 class="text-3xl font-bold text-gray-900">
                Create your account
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Join Setyo Barbershop membership
            </p>

        </div>

        <div class="progress mb-6">
            <div id="progressBar" class="progress-bar"></div>
        </div>

        <div class="card p-6">

            <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-5">

                @csrf

                <div class="field">
                    <input type="text" name="name" required placeholder=" ">
                    <label>Full name</label>
                </div>

                <div class="field">
                    <input type="email" name="email" required placeholder=" ">
                    <label>Email</label>
                </div>

                <div>

                    <label class="text-sm font-medium text-gray-700 block mb-2">
                        WhatsApp number
                    </label>

                    <div class="flex gap-2">

                        <div class="flex items-center px-3 border rounded-lg text-sm bg-gray-50">
                            +62
                        </div>

                        <input id="wa_number" type="text" name="wa_number" required
                            class="flex-1 border rounded-lg px-4 py-3 text-sm">

                        <button
                            type="button"
                            id="sendOtpBtn"
                            class="bg-gray-900 text-white text-xs px-4 rounded-lg flex items-center gap-2 justify-center">

                            <span id="otpText">Send OTP</span>

                            <div id="spinner" class="spinner hidden"></div>

                        </button>

                    </div>

                    <p id="countdown" class="text-xs text-gray-500 mt-2"></p>

                </div>

                <div>

                    <label class="text-sm font-medium text-gray-700 block mb-2">
                        OTP Code
                    </label>

                    <div class="otp">

                        <input maxlength="1">
                        <input maxlength="1">
                        <input maxlength="1">
                        <input maxlength="1">
                        <input maxlength="1">
                        <input maxlength="1">

                    </div>

                    <input type="hidden" name="otp" id="otp">

                </div>

                <div class="field password-wrapper">

                    <input type="password" id="password" name="password" required placeholder=" ">

                    <label>Password</label>

                    <span class="toggle-password" onclick="togglePassword('password')">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />

                            <circle cx="12" cy="12" r="3" />

                        </svg>

                    </span>

                </div>

                <div class="field password-wrapper">

                    <input type="password" id="confirmPassword" name="password_confirmation" required placeholder=" ">

                    <label>Confirm password</label>

                    <span class="toggle-password" onclick="togglePassword('confirmPassword')">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.8" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />

                            <circle cx="12" cy="12" r="3" />

                        </svg>

                    </span>

                </div>

                <button type="submit" class="btn">
                    Create account
                </button>

            </form>

        </div>
 <p class="text-center text-sm text-gray-500 mt-6">

            Already have an account?

            <a href="{{ route('login') }}" class="text-blue-600 font-medium">
                Login
            </a>

        </p>
    </div>

    <script>
        /* toggle password */

        function togglePassword(id) {
            const input = document.getElementById(id)
            input.type = input.type === "password" ? "text" : "password"
        }

        /* toast */

        function toast(msg) {
            const t = document.getElementById("toast")
            t.textContent = msg
            t.classList.add("show")
            setTimeout(() => t.classList.remove("show"), 3000)
        }

        /* OTP auto focus */

        const inputs = document.querySelectorAll(".otp input")
        const hidden = document.getElementById("otp")

        inputs.forEach((input, i) => {

            input.addEventListener("input", () => {

                if (input.value && i < 5) {
                    inputs[i + 1].focus()
                }

                updateOtp()

            })

            input.addEventListener("keydown", e => {

                if (e.key === "Backspace" && !input.value && i > 0) {
                    inputs[i - 1].focus()
                }

            })

        })

        function updateOtp() {
            hidden.value = [...inputs].map(i => i.value).join("")
        }

        /* paste OTP */

        document.addEventListener("paste", e => {

            const text = (e.clipboardData || window.clipboardData).getData("text")

            if (text.length === 6) {

                inputs.forEach((input, i) => input.value = text[i])
                updateOtp()

            }

        })

        /* send OTP */

        let countdown = 0

        document.getElementById("sendOtpBtn").onclick = () => {

            if (countdown > 0) return

            const wa = document.getElementById("wa_number").value.trim()
            const email = document.querySelector('[name="email"]').value.trim()

            if (!wa) {
                toast("Masukkan nomor WhatsApp")
                return
            }

            if (!email) {
                toast("Masukkan email terlebih dahulu")
                return
            }

            const spinner = document.getElementById("spinner")
            const text = document.getElementById("otpText")

            spinner.classList.remove("hidden")
            text.textContent = "Sending..."

            fetch("{{ route('wa.send_otp') }}", {

                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },

                    body: JSON.stringify({
                        wa_number: wa,
                        email: email
                    })

                })

                .then(res => res.json())
                .then(data => {

                    toast(data.message || "OTP sent to WhatsApp & Email")
                    startCountdown()

                })
                .catch(() => toast("Failed sending OTP"))

                .finally(() => {

                    spinner.classList.add("hidden")
                    text.textContent = "Send OTP"

                })

        }

        function startCountdown() {

            const el = document.getElementById("countdown")

            countdown = 30

            const timer = setInterval(() => {

                countdown--

                el.textContent = "Resend OTP in " + countdown + "s"

                if (countdown <= 0) {
                    clearInterval(timer)
                    el.textContent = "You can resend OTP"
                }

            }, 1000)

        }
    </script>

</body>

</html>