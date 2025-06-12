@extends('layouts.nav')
@section('title', 'Lupa Password')
@section('content')

<div class="flex justify-center items-center min-h-[90vh]">
    <div class="w-full max-w-sm bg-pink-200 text-[#3C5294] p-6 rounded-lg shadow-lg">

        @if (session('status'))
            <div class="mb-4 text-green-500 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                {{ __('Mohon periksa kembali email Anda.') }}
            </div>
        @endif

        <div class="mb-4 text-sm">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" class="mt-1 block w-full rounded border border-gray-300 p-2" type="email" name="email" value="{{ old('email') }}" required autofocus />
            </div>

            <button type="submit" class="w-full bg-[#3C5294] text-white px-4 py-2 rounded hover:bg-blue-900 mt-4">
                Kirim Link Reset Password
            </button>
        </form>
    </div>
</div>

@endsection
