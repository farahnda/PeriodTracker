{{-- resources/views/calendar/index.blade.php --}}
@extends('layouts.nav')
@section('title', 'Kalender')
@section('content')

<div class="container">
    <h2>Kalender Menstruasi</h2>
    <div class="row">
        <div class="col-md-8">
            <div id='calendar'></div>
             <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
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
        </div>
        <div class="col-md-4">
            <h5>Prediksi</h5>
            <ul>
                <li>Periode berikutnya: {{ $nextPeriod ?? 'Belum tersedia' }}</li>
                <li>Masa subur: {{ $fertileWindow ?? 'Belum tersedia' }}</li>
                <!-- Tambahkan prediksi lainnya -->
            </ul>
        </div>
    </div>
</div>
@endsection