{{-- resources/views/profiles/show.blade.php --}}
@extends('layouts.nav')
@section('title', 'Profile')
@section('content')

<div class="flex flex-col items-center min-h-[90vh] pt-10">
    <div class="w-full max-w-sm bg-pink-200 text-[#3C5294] p-6 rounded-4 shadow">
        <h2 class="text-xl text-center font-bold mb-4">PROFIL AKUN</h2>

        <div class="flex justify-center mb-4">
            <img class="w-24 h-24 rounded-full object-cover" src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1114445501.jpg" alt="Profile Picture">
        </div>

        <div class="mb-3">
            <p class="font-semibold text-sm">Username</p>
            <p class="text-sm">{{ $profile->name }}</p>
        </div>

        <div class="mb-3">
            <p class="font-semibold text-sm">Email</p>
            <p class="text-sm">{{ $profile->email }}</p>
        </div>

        <div class="mb-3">
            <p class="font-semibold text-sm">Tanggal Lahir</p>
            <p class="text-sm">
                {{ $profile->birth_date ? $profile->birth_date : 'Belum tersedia' }}
            </p>
        </div>
    </div>
    
    {{-- Tombol di luar card --}}
    <div class="mt-4 flex justify-between max-w-sm mx-auto w-full">
        <a href="/"
            class="text-center bg-[#f3bdbd] text-white font-bold rounded-[16px] py-[10px] px-8 hover:bg-[#d89a9a] transition">
            Kembali
        </a>
        <a href="{{ route('profiles.edit', $profile->id) }}"
            class="text-center bg-[#f3bdbd] text-white font-bold rounded-[16px] py-[10px] px-8 hover:bg-[#d89a9a] transition">
            Sunting
        </a>
    </div>
</div>
@endsection
