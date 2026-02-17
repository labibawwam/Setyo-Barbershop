@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Verifikasi Email dengan OTP</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 mb-4">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.otp.verify') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Kode OTP</label>
            <input type="text" name="code" value="{{ old('code') }}" class="mt-1 block w-full" required />
            @error('code')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">Verifikasi</button>
        </div>
    </form>

    <form method="POST" action="{{ route('verification.otp.send') }}" class="mt-4">
        @csrf
        <button type="submit" class="btn btn-secondary">Kirim Ulang OTP ke Email</button>
    </form>
</div>
@endsection
