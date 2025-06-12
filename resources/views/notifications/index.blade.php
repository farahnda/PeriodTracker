@extends('layouts.nav')

@section('title', 'Notifikasi')

@section('content')
<div class="max-w-4xl mx-auto bg-[#EBDBD3] rounded-xl shadow-lg p-6 text-[#3C5294] mt-8">
    <h2 class="text-3xl font-extrabold mb-8 border-b border-[#d3bfb5] pb-4">
        Notifikasi
    </h2>

    @if ($notifications->count())
        <div class="divide-y divide-[#d3bfb5]">
            @foreach ($notifications as $notification)
                <a href="{{ route('notifications.detail', $notification->id) }}"
   class="flex justify-between items-center p-4 rounded-lg cursor-pointer transition-colors duration-200
          {{ $notification->read_at 
              ? 'bg-gray-300 text-gray-700 hover:bg-[#bdbdbd] hover:text-gray-100' 
              : 'bg-gray-200 font-semibold text-[#3C5294] hover:bg-[#d6c4b9] hover:text-[#3C5294]' }}">
    <div>
        <div class="text-base">
            {{ $notification->data['title']}}
        </div>
        <div class="text-sm text-gray-700">
            {{ $notification->created_at->diffForHumans() }}
        </div>
    </div>
    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
</a>

            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @else
        <p class="text-gray-600">Tidak ada notifikasi.</p>
    @endif
</div>
@endsection
