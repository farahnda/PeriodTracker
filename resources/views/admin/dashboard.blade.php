@extends('layouts.nav')

@section('content')
<div class="container mx-auto px-4 py-10">
  <!-- Salam Selamat Datang -->
  <div class="mb-10 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Hai, {{ Auth::user()->name }} 👋</h1>
    <p class="text-gray-600 text-lg">
      Selamat datang di halaman dashboard admin. Silakan kelola data pengguna dan artikel di bawah ini.
    </p>
  </div>

  <!-- Kartu Manajemen -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Kartu User -->
    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between">
      <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Manajemen User</h2>
        <p class="text-gray-600 mb-4">Lihat, edit, dan hapus data pengguna yang terdaftar di sistem.</p>
      </div>
      <a href="{{ route('admin.users.index') }}"
         class="inline-block text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Kelola User
      </a>
    </div>

    <!-- Kartu Artikel -->
    <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between">
      <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Manajemen Artikel</h2>
        <p class="text-gray-600 mb-4">Tambah, ubah, atau hapus artikel yang tampil di aplikasi.</p>
      </div>
      <a href="{{ route('admin.articles.index') }}"
         class="inline-block text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        Kelola Artikel
      </a>
    </div>
  </div>
</div>
@endsection
