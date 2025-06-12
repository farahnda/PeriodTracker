@extends('layouts.nav')
@section('title', 'Hasil Prediksi')
@section('content')

<style>
.card,
.card-body {
  background-color: transparent !important;
  border: none !important;
}

.card-prediksi {
  background-color: #EBDBD3 !important;
  border-radius: 1rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.card-prediksi .card-body {
  background-color: #EBDBD3 !important;
  color: #3C5294;
  padding: 1rem;
}

#calendar {
  max-width: 100%;
  margin: 0 auto;
  background-color: #EBDBD3;
  color: #3C5294;
  border-radius: 1rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 1rem;
}

.fc-daygrid-day {
  cursor: pointer;
  border: 1px solid #aaa !important;
}
.fc-daygrid-day:hover {
  background-color: #a0c4ff;
}

.fc-col-header-cell {
  border: 1px solid #aaa;
  font-weight: bold;
}
.fc .fc-col-header-cell {
  border: 1px solid #aaa;
}
.fc-scrollgrid {
  border: 1px solid #aaa !important;
}

.menstruation-day {
  background-color: #a94064 !important;
  color: white;
  border: none;
}
.next-day {
  background-color: #c093a3 !important;
  color: white;
  border: none;
}
.fertile-day {
  background-color: #365393 !important;
  color: white;
  border: none;
}

@media (max-width: 992px) {
  .container.d-flex {
    flex-direction: column !important;
    align-items: stretch !important;
    min-height: unset !important;
  }
  .col-md-6,
  .col-md-5 {
    max-width: 100%;
    flex: 0 0 100%;
    margin-right: 0 !important;
    margin-bottom: 1.5rem !important;
  }
}

@media (max-width: 576px) {
  .card-prediksi .card-body {
    padding: 0.75rem;
    font-size: 0.95rem;
  }
  #calendar {
    min-width: 280px;
    font-size: 0.85rem;
  }
}
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <!-- Kalender -->
    <div class="col-md-6 mb-4 me-md-4">
      <div class="card h-100">
        <div class="card-body">
          <div id="calendar" class="w-100"></div>
        </div>
      </div>
    </div>

    <!-- Hasil Prediksi -->
    <div class="col-md-5">
      @forelse($calendars as $calendar)
      <div class="card card-prediksi border-0 rounded-4 shadow overflow-hidden p-2">
        <div class="card-body">
          <h4 class="mb-4 fw-bold" style="font-size: 1.5rem;">Hasil Prediksi</h4>
          <p class="d-flex">
            <span class="fw-semibold" style="width: 50%;">Hari pertama menstruasi</span>
            <span>: {{ $start_date ? $start_date->locale('id')->translatedFormat('l, d F Y') : 'Belum tersedia' }}</span>
          </p>
          <p class="d-flex">
            <span class="fw-semibold" style="width: 50%;">Hari terakhir menstruasi</span>
            <span>: {{ $end_date ? $end_date->locale('id')->translatedFormat('l, d F Y') : 'Belum tersedia' }}</span>
          </p>
          <p class="d-flex">
            <span class="fw-semibold" style="width: 50%;">Lama siklus</span>
            <span>: {{ $cyclelength ?? 'Belum tersedia' }}</span>
          </p>
          <p class="d-flex">
            <span class="fw-semibold" style="width:50%;">Lama menstruasi</span>
            <span>: {{ $periodlength ?? 'Belum tersedia' }}</span>
          </p>

          <br>
          <hr>
          <br>

          <p class="d-flex">
            <span class="fw-semibold" style="width: 50%;">Mulai menstruasi berikutnya</span>
            <span>: {{ $next_start_date ? $next_start_date->locale('id')->translatedFormat('l, d F Y') : 'Belum tersedia' }}</span>
          </p>
          <p class="d-flex">
            <span class="fw-semibold" style="width: 50%;">Akhir menstruasi berikutnya</span>
            <span>: {{ $next_end_date ? $next_end_date->locale('id')->translatedFormat('l, d F Y') : 'Belum tersedia' }}</span>
          </p>
          <p class="d-flex">
            <span class="fw-semibold" style="width: 50%;">Masa subur</span>
            <span>:
              @if ($fertile_start_date && $fertile_end_date)
                {{ $fertile_start_date->locale('id')->translatedFormat('d F') }} - 
                {{ $fertile_end_date->locale('id')->translatedFormat('d F Y') }}
              @else
                Belum tersedia
              @endif
            </span>
          </p>      
                
          <div class="mt-4 text-center">
            <a href="{{ route('calendars.create') }}" 
              class="btn btn-md text-white fw-bold px-4 py-2 rounded-[8px] border border-[#2c3d75] bg-[#1F2937] hover:bg-[#161F2B] hover:border-[#1f2a54] transition"
              style="color: #fff; text-decoration: none; font-weight: bold; display: inline-block; min-width: 150px;">
              Prediksi Lagi
            </a>
          </div>

          <div class="mt-3 d-flex justify-content-center gap-2">
            <a href="{{ route('calendars.edit', $calendar->id) }}" 
              class="btn btn-md text-white fw-bold px-4 py-2 bg-[#d89a9a] hover:bg-[#c57f7f] transition"
              style="text-decoration: none; min-width: 120px;">
              Edit Prediksi
            </a>

            <form action="{{ route('calendars.destroy', $calendar->id) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus prediksi ini?')" 
                  style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-md text-white fw-bold px-4 py-2 bg-[#800000] border-[#660000] hover:bg-[#660000] hover:border-[#4d0000]"">
                Hapus Prediksi
              </button>
            </form>
          </div>

        </div>
      </div>
      @empty
      <div class="card card-prediksi border-0 rounded-4 shadow overflow-hidden p-2">
        <div class="card-body">
          <h4 class="mb-4 fw-bold" style="font-size: 1.5rem;">Hasil Prediksi</h4>
          <p class="text-muted text-center">Belum ada prediksi yang tersedia.</p>
          <div class="text-center mt-4">
            <a href="{{ route('calendars.create') }}" 
              class="btn btn-md text-white fw-bold px-4 py-2 rounded-[8px] border border-[#2c3d75] bg-[#1F2937] hover:bg-[#161F2B] hover:border-[#1f2a54] transition"
              style="color: #fff; text-decoration: none; font-weight: bold;">
              Mulai Prediksi
            </a>
          </div>
        </div>
      </div>
      @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
      firstDay: 1,
      selectable: true,
      editable: true,
      events: @json($events), 
    });
    calendar.render();
  });
</script>
@endsection