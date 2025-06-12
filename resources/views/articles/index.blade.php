{{-- filepath: resources/views/article/index.blade.php --}}
@extends('layouts.nav')
@section('title', 'Artikel')
@section('content')
<section class="py-8">
  <div class="max-w-6xl mx-auto px-4">
    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-10 gap-x-6">
      @forelse($articles as $article)
        <li class="rounded-lg shadow hover:shadow-lg transition overflow-hidden" style="background: #EBDBD3;">
          {{-- Gambar --}}
          @if($article->image_url)
            <img
              src="{{ $article->image_url }}"
              alt="{{ $article->title }}"
              class="h-48 w-full object-cover"
            />
          @else
            <div class="h-48 w-full bg-gray-300"></div>
          @endif

          <div class="p-4 flex flex-col flex-grow">
            {{-- Label “Artikel” + Judul --}}
            <h3 class="mb-1 text-slate-900 font-semibold">
              <span class="block text-sm leading-6 text-indigo-500">Artikel</span>
              {{ $article->title }}
            </h3>

            {{-- Ringkasan konten --}}
            <div class="prose prose-slate prose-sm text-slate-600 flex-grow">
              <p>{!! \Illuminate\Support\Str::limit($article->content, 80) !!}</p>
            </div>

            {{-- Tombol “Baca lebih…” --}}
            <a href="{{ $article->link }}" target="_blank" rel="noopener"
               class="mt-6 inline-flex items-center h-9 rounded-full text-sm font-semibold px-3 bg-slate-100 text-slate-700
                      hover:bg-slate-200 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500 transition">
              Baca lebih lanjut
              <svg class="ml-3 overflow-visible text-slate-300 group-hover:text-slate-400"
                   width="3" height="6" viewBox="0 0 3 6" fill="none"
                   stroke="currentColor" stroke-width="2" stroke-linecap="round"
                   stroke-linejoin="round">
                <path d="M0 0L3 3L0 6"></path>
              </svg>
            </a>
          </div>
        </li>
      @empty
        <li class="col-span-full text-center text-gray-500 py-8">
          Belum ada artikel tersedia.
        </li>
      @endforelse
    </ul>
  </div>
</section>

<script>
@if(session()->has('success'))
    toastr.success('{{ session('success') }}', 'BERHASIL!');
@elseif(session()->has('error'))
    toastr.error('{{ session('error') }}', 'GAGAL!');
@endif
</script>
</body>
</html>
@endsection