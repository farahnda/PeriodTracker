@extends('layouts.nav')

@section('title', 'Notifikasi')
@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <h1 class="text-xl font-bold mb-4">Notifikasi</h1>
    <ul class="space-y-4">
        @foreach ($notifications as $notification)
            <li class="bg-white p-4 shadow rounded">
                <strong>{{ $notification->data['title'] }}</strong><br>
                {{ $notification->data['body'] }}<br>
                <a href="{{ $notification->data['url'] }}" class="text-blue-500 underline">Lihat detail</a>
                <span class="block text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
