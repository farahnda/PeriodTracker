{{-- resources/views/profiles/edit.blade.php --}}
@extends('layouts.nav')
@section('title', 'Edit Profile')
@section('content')

<div class="flex flex-col items-center min-h-[90vh] pt-10">
    <div class="w-full max-w-sm bg-[#EBDBD3] text-[#3C5294] p-6 rounded-4 shadow">
        <h2 class="text-xl text-center font-bold mb-4">EDIT PROFILE</h2>
        <form action="{{ route('profiles.update', $profile->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="font-semibold text-sm" for="name">Nama</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full rounded border p-2 text-[#3C5294] @error('name') border-red-500 @enderror"
                    value="{{ old('name', $profile->name) }}"
                    placeholder="Masukkan Nama"
                />
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold text-sm" for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    class="mt-1 block w-full rounded border p-2 text-[#3C5294] @error('email') border-red-500 @enderror"
                    value="{{ old('email', $profile->email) }}"
                    placeholder="Masukkan Email"
                />
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold text-sm" for="password">Password <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded border p-2 text-[#3C5294] @error('password') border-red-500 @enderror"
                    placeholder="Masukkan Password Baru"
                />
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold text-sm" for="password_confirmation">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full rounded border p-2 text-[#3C5294]"
                    placeholder="Konfirmasi Password Baru"
                />
            </div>

            <div>
                <label class="font-semibold text-sm" for="birth_date">Tanggal Lahir (Opsional)</label>
                <input
                    id="birth_date"
                    name="birth_date"
                    type="date"
                    class="mt-1 block w-full rounded border p-2 text-[#3C5294] @error('birth_date') border-red-500 @enderror"
                    value="{{ old('birth_date', $profile->birth_date) }}"
                />
                @error('birth_date')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex justify-between max-w-sm mx-auto w-full gap-2">
                <a href="/profiles/{{ Auth::id() }}"
                    class="flex-1 text-center bg-[#d89a9a] hover:bg-[#c57f7f] text-white font-bold rounded-[16px] py-[10px] px-8 transition">
                    Kembali
                </a>
                <button type="submit"
                    class="flex-1 text-center bg-[#d89a9a] hover:bg-[#c57f7f] text-white font-bold rounded-[16px] py-[10px] px-8 transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
