@extends('layouts.nav')
@section('title', 'Register')
@section('content')

<div class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-sm bg-pink-200 text-[#3C5294] p-6 rounded-lg shadow-lg">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium">Name</label>
                <input id="name" name="name" type="text" class="mt-1 block w-full rounded border border-gray-300 p-2" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" class="mt-1 block w-full rounded border border-gray-300 p-2" value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input id="password" name="password" type="password" class="mt-1 block w-full rounded border border-gray-300 p-2" required>
                @error('password')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded border border-gray-300 p-2" required>
                @error('password_confirmation')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('login') }}" class="text-sm underline hover:text-indigo-800">
                    Already registered?
                </a>

                <button type="submit" class="bg-[#3C5294] text-white px-4 py-2 rounded hover:bg-blue-900">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
