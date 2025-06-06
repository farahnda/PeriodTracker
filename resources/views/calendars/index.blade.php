@extends('layouts.nav')
@section('title', 'Hasil Prediksi')
@section('content')

<style>
.card {
  background-color: transparent !important;
  border: none !important;
}
.card-body {
  background-color: transparent !important;
  }
.card-prediksi {
  background-color: #EBDBD3 !important;
  border-radius: 1rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.card-prediksi .card-body {
  background-color: #EBDBD3 !important;
  color: #3C5294;
  padding: 1rem;
}

#calendar {
  max-width: 100%;
  margin: 0 auto;
}

.fc-daygrid-day {
  cursor: pointer;
}

.fc-daygrid-day:hover {
  background-color: #a0c4ff;
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
              @if ($fertile_start && $fertile_end)
                {{ $fertile_start->locale('id')->translatedFormat('d F') }} - 
                {{ $fertile_end->locale('id')->translatedFormat('d F Y') }}
              @else
                Belum tersedia
              @endif
            </span>
          </p>      
                
          <div class="text-left mt-4">
            <a href="{{ route('calendars.create') }}" 
              class="btn btn-md text-white fw-bold px-4 py-2 rounded-[8px] border border-[#2c3d75] bg-[#1F2937] hover:bg-[#161F2B] hover:border-[#1f2a54] transition"
              style="color: #fff; text-decoration: none; font-weight: bold; flex: 1; text-align: center;">
              Prediksi Lagi
            </a>
          </div>
        </div>
      </div>
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
      events: '/events',
      select: function (info) {
        let title = prompt('Event Title:');
        if (title) {
          fetch('/events', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
              title: title,
              start: info.startStr,
              end: info.endStr
            })
          }).then(() => calendar.refetchEvents());
        }
      },
      eventDrop: function (info) {
        fetch(`/events/${info.event.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            start: info.event.start.toISOString(),
            end: info.event.end ? info.event.end.toISOString() : null
          })
        });
      },
      eventClick: function (info) {
        if (confirm('Hapus event ini?')) {
          fetch(`/events/${info.event.id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
          }).then(() => calendar.refetchEvents());
        }
      }
    });
    calendar.render();
  });
</script>
@endsection