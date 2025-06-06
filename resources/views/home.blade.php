@extends('layouts.nav')

@section('content')
<style>
.card {
  background-color: transparent !important;
  border: none !important;
}
.card-body {
  background-color: transparent !important;
}

#calendar {
max-width: 100%;
margin: 0 auto;
}
/* Warna background default tanggal */
.fc-daygrid-day {
  cursor: pointer; /* biar keliatan bisa dihover */
}
/* Saat hover, ubah background jadi warna lain */
.fc-daygrid-day:hover {
  background-color: #a0c4ff; /* contoh warna biru muda */
} 

@media (max-width: 768px) {
  #calendar {
    scale: 1;
    transform-origin: top left;
  }
}

@media (max-width: 576px) {
  #calendar {
    scale: 1;
    transform-origin: top left;
  }
}
</style>

<div class="container mt-4">
  <!-- Baris 1: Kalender + Welcome -->
  <div class="row">
    <!-- Kalender -->
    <div class="col-md-6 mb-3">
      <div class="card h-100">
        <div class="card-body">
            <div id="calendar" class="w-100"></div>
        </div>
      </div>
    </div>

    <!-- Welcome + Tombol -->
    <div class="col-md-6 mb-3 d-flex flex-column justify-content-center">
        <div class="card">
            <div class="card-body text-center">
                <h1 
                  class="card-title fw-bold text-white {{ Auth::check() ? 'text-center' : 'text-right' }}" 
                  style="font-size: 5rem; font-family: 'Raqillas', sans-serif;"
                >
                  Hai, {{ Auth::check() ? Auth::user()->name : 'Pengunjung' }}!
                </h1>
                <p class="text-white mt-3 fs-5">
                    Kami hadir untuk membantumu memahami siklus tubuhmu dengan lebih baik. Mulai dari prediksi menstruasi hingga informasi penting seputar kesehatan reproduksi — semuanya dalam satu tempat yang mudah digunakan.
                </p>
                <a href="{{ route('calendars.create') }}" 
                    class="btn fw-bold text-white mt-4 px-4 py-2 fs-5 rounded"
                    style="background-color: #1F2937;"
                    onmouseover="this.style.backgroundColor='#161F2B';"
                    onmouseout="this.style.backgroundColor='#1F2937';">
                    Mulai Prediksi
                </a>
            </div>
        </div>
    </div>

{{-- <!-- Baris 2: Kumpulan Artikel -->
<div class="row mt-5">
  <div class="col-12">
    <div class="p-4 rounded" style="color: #1F2937; background-color: #ffffff;">
      <!-- Header -->
      <h2 class="text-center fw-bold mb-4" style="font-size: 2rem;">
        Kumpulan Artikel
      </h2>

      <!-- List Artikel -->
      <div class="list-group">
        @forelse ($articles as $article)
          <a href="{{ route('articles.show', $article->id) }}"
             class="list-group-item list-group-item-action mb-3"
             style="background: #EBDBD3;">
            {{ $article->title }}
          </a>
        @empty
          <p class="text-muted text-center">Belum ada artikel.</p>
        @endforelse
      </div>
    </div>
  </div>
</div> --}}

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id', // bahasa indonesia
      firstDay: 1,  // hari senin hari pertama (0 = Minggu, 1 = Senin, dst)
    });
    calendar.render();
  });
</script>
@endsection