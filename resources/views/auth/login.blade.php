<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | STY Barber</title>

@vite(['resources/css/app.css','resources/js/app.js'])

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

body{
font-family:'Inter',sans-serif;
background:#f8fafc;
}

/* card */

.card{
background:white;
border:1px solid #e5e7eb;
border-radius:16px;
box-shadow:0 20px 40px rgba(0,0,0,0.05);
}

/* floating input */

.field{
position:relative;
}

.field input{
width:100%;
border:1px solid #e5e7eb;
padding:16px 14px;
border-radius:10px;
font-size:14px;
background:white;
}

.field label{
position:absolute;
left:14px;
top:14px;
font-size:13px;
color:#6b7280;
transition:.2s;
background:white;
padding:0 4px;
}

.field input:focus+label,
.field input:not(:placeholder-shown)+label{
top:-8px;
font-size:11px;
color:#2563eb;
}

.field input:focus{
outline:none;
border-color:#2563eb;
box-shadow:0 0 0 3px rgba(37,99,235,.15);
}

/* password */

.password-wrapper{
position:relative;
}

.password-wrapper input{
padding-right:44px;
}

.toggle-password{
position:absolute;
right:12px;
top:50%;
transform:translateY(-50%);
width:22px;
height:22px;
cursor:pointer;
color:#6b7280;
}

.toggle-password:hover{
color:#2563eb;
}

/* button */

.btn{
background:#111827;
color:white;
padding:12px;
border-radius:10px;
font-weight:600;
width:100%;
transition:.2s;
}

.btn:hover{
background:#2563eb;
}

/* toast */

.toast{
position:fixed;
top:20px;
right:20px;
background:#111827;
color:white;
padding:12px 18px;
border-radius:8px;
opacity:0;
transform:translateY(-10px);
transition:.3s;
z-index:100;
}

.toast.show{
opacity:1;
transform:translateY(0);
}

/* responsive */

@media(max-width:640px){

h1{
font-size:26px;
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
Welcome Back
</h1>

<p class="text-gray-500 text-sm mt-1">
Login to Setyo Barbershop
</p>

</div>

<div class="card p-6">

@if (session('status'))
<div class="text-green-600 text-sm mb-4">
{{ session('status') }}
</div>
@endif

<form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-5">

@csrf

<div class="field">

<input id="identifier" type="text" name="identifier" required placeholder=" ">

<label>Email or WhatsApp</label>

@error('identifier')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror

</div>

<div class="field password-wrapper">

<input id="password" type="password" name="password" required placeholder=" ">

<label>Password</label>

<span class="toggle-password" onclick="togglePassword()">

<svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">

<path stroke-linecap="round" stroke-linejoin="round"
d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>

<circle cx="12" cy="12" r="3"/>

</svg>

</span>

</div>

@if (Route::has('password.request'))

<div class="text-right">

<a href="{{ route('password.request') }}"
class="text-sm text-blue-600 hover:underline">

Forgot password?

</a>

</div>

@endif

<button type="submit" class="btn">
Login
</button>

</form>

</div>

<p class="text-center text-sm text-gray-500 mt-6">

Don't have an account?

<a href="{{ route('register') }}" class="text-blue-600 font-medium">
Register
</a>

</p>

</div>

<script>

/* toast */

function toast(msg){

const t=document.getElementById("toast")
t.textContent=msg
t.classList.add("show")

setTimeout(()=>t.classList.remove("show"),3000)

}

/* toggle password */

function togglePassword(){

const input=document.getElementById("password")

if(input.type==="password"){
input.type="text"
}else{
input.type="password"
}

}

/* remember identifier */

const identifier=document.getElementById("identifier")

const saved=localStorage.getItem("remembered_identifier")

if(saved){
identifier.value=saved
}

document.getElementById("loginForm").addEventListener("submit",()=>{

localStorage.setItem("remembered_identifier",identifier.value)

})

</script>

</body>

</html>