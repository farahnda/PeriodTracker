@extends('layouts.nav')
@section('title', 'Masuk Akun')
@section('content')

<div class="flex justify-center items-center  min-h-[90vh]">
    <div class="w-full max-w-sm bg-pink-200 text-[#3C5294] p-6 rounded-lg shadow-lg">
        @if (session('status'))
            <div class="mb-4 text-green-500 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                Email atau password salah, atau akun belum terdaftar.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" class="mt-1 block w-full rounded border border-gray-300 p-2" type="email" name="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input id="password" class="mt-1 block w-full rounded border border-gray-300 p-2" type="password" name="password" required />
            </div>

            {{-- <!-- Remember Me -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600" />
                    <span class="ml-2 text-sm">Remember me</span>
                </label>
            </div> --}}

            <div class="flex justify-between items-center text-sm mx-auto">
                @if (Route::has('password.request'))
                    <a class="underline hover:text-indigo-800" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
                <a class="underline hover:text-indigo-800" href="{{ route('register') }}">
                    Akun baru?
                </a>
            </div>

            <button type="submit" class="w-full bg-[#3C5294] text-white px-4 py-2 rounded hover:bg-blue-900 mt-4">
                Masuk
            </button>

        </form>
    </div>
</div>

@endsection
