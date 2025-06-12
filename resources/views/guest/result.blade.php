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
            <div class="card card-prediksi border-0 rounded-4 shadow overflow-hidden p-2" style="background-color: #EBDBD3;">
                <div class="card-body" style="color: #3C5294; padding: 1rem;">
                    <h4 class="mb-4 fw-bold" style="font-size: 1.5rem;">Hasil Prediksi</h4>

                    <p class="d-flex">
                        <span class="fw-semibold" style="width: 50%;">Hari pertama menstruasi</span>
                        <span>: {{ $start_date->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </p>
                    <p class="d-flex">
                        <span class="fw-semibold" style="width: 50%;">Hari terakhir menstruasi</span>
                        <span>: {{ $end_date->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </p>
                    <p class="d-flex">
                        <span class="fw-semibold" style="width: 50%;">Lama siklus</span>
                        <span>: {{ $cyclelength }} hari</span>
                    </p>
                    <p class="d-flex">
                        <span class="fw-semibold" style="width:50%;">Lama menstruasi</span>
                        <span>: {{ $periodlength }} hari</span>
                    </p>

                    <br>
                    <hr>
                    <br>

                    <p class="d-flex">
                        <span class="fw-semibold" style="width: 50%;">Mulai menstruasi berikutnya</span>
                        <span>: {{ $next_start_date->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </p>
                    <p class="d-flex">
                        <span class="fw-semibold" style="width: 50%;">Akhir menstruasi berikutnya</span>
                        <span>: {{ $next_end_date->locale('id')->translatedFormat('l, d F Y') }}</span>
                    </p>
                    <p class="d-flex">
                        <span class="fw-semibold" style="width: 50%;">Masa subur</span>
                        <span>: {{ $fertile_start_date->locale('id')->translatedFormat('d F') }} - {{ $fertile_end_date->locale('id')->translatedFormat('d F Y') }}</span>
                    </p>

                    <div class="text-left mt-4">
                        <a href="{{ route('calendars.create') }}" 
                           class="btn btn-md text-white fw-bold px-4 py-2"
                           style="background-color: #3C5294; border-color: #2c3d75;"
                           onmouseover="this.style.backgroundColor='#2c3d75';"
                           onmouseout="this.style.backgroundColor='#3C5294';">
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
      events: @json($events), 
    });
    calendar.render();
  });
</script>
@endsection
