@extends('layouts.nav')

@section('title', 'Detail Notifikasi')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-10 text-[#3C5294]">
    <h2 class="text-2xl font-bold mb-4 border-b border-[#d3bfb5] pb-2">
        {{ $notif->data['title'] }}
    </h2>

    <p class="mb-4 text-gray-800">
        {{ $notif->data['body'] }}
    </p>

    @if(isset($notif->data['url']))
        <a href="{{ $notif->data['url'] }}" 
           class="text-blue-600 underline hover:text-blue-800 transition duration-200">
            Lihat Terkait
        </a>
    @endif

    <p class="mt-6 text-sm text-gray-500">
        Diterima: {{ $notif->created_at->format('d M Y, H:i') }}
    </p>

    <a href="{{ route('notifications.index') }}" 
       class="mt-6 inline-block text-sm text-blue-500 hover:underline">
        ← Kembali ke daftar notifikasi
    </a>
</div>
@endsection

