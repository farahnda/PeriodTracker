{{-- resources/views/calendars/index.blade.php --}}
@extends('layouts.nav')
@section('title', 'Kalender')
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

@media (max-width: 768px) {
  #calendar {
    scale: 0.85;
    transform-origin: top left;
  }
}

@media (max-width: 576px) {
  #calendar {
    scale: 0.75;
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

    <div class="col-md-6 mb-3 d-flex flex-column justify-content-center" >
        <div class="border-0 rounded p-10" style="background-color: #EBDBD3;">
            <div>
            <h5>Prediksi</h5>
            <ul>
                <li>Periode berikutnya: {{ $nextPeriod ?? 'Belum tersedia' }}</li>
                <li>Tanggal akhir periode: {{ $endDate ?? 'Belum tersedia' }}</li>
                <li>Masa subur: {{ $fertileWindow ?? 'Belum tersedia' }}</li>
                <!-- Tambahkan prediksi lainnya -->
            </ul>
            </div>
        </div>
    </div>


<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'id',
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