@extends('layouts.guest')

@section('content')
<div class="max-w-md mx-auto mt-16">
    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-2xl font-bold mb-2">Verify WhatsApp Number</h2>
        <p class="text-sm text-gray-600 mb-4">Kode OTP telah dikirimkan ke nomor: <strong>+62{{ $user->wa_number }}</strong>. Masukkan 6 digit kode untuk menyelesaikan pendaftaran.</p>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('wa.verify') }}">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">OTP Code</label>
                <input name="code" type="text" inputmode="numeric" maxlength="6" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3">
                @error('code')<p class="text-red-600 text-sm mt-2">{{ $message }}</p>@enderror
            </div>

            <div class="mt-4 flex items-center justify-between">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Verify</button>

                <form method="POST" action="{{ route('wa.verify.resend') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-600">Resend code</button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
