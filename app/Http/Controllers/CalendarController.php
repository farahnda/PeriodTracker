<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Calendar;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $calendars = Calendar::where('user_id', $userId)->get();

        $events = $calendars->flatMap(function ($item) {
            $startDate = Carbon::parse($item->start_date);
            $endDate = Carbon::parse($item->end_date);
            $eventDays = [];

            while ($startDate->lte($endDate)) {
                $eventDays[] = [
                    'start' => $startDate->toDateString(),
                    'end' => $startDate->toDateString(), 
                    'className' => 'menstruation-day', 
                ];
                $startDate->addDay(); 
            }

            return $eventDays;
        });


        $last = $calendars->sortByDesc('start_date')->first();

        $start_date = $last ? Carbon::parse($last->start_date) : null;
        $end_date = $last ? Carbon::parse($last->end_date) : null;
        $cyclelength = $last ? $last->cyclelength : null;
        $periodlength = $last ? $last->periodlength : null;

        if ($last) {
            $next_start_date = $start_date->copy()->addDays($cyclelength);
            $next_end_date = $next_start_date->copy()->addDays($periodlength - 1);
            $fertile_start = $next_start_date->copy()->subDays(14);
            $fertile_end = $fertile_start->copy()->addDays(4);
        } else {
            $next_start_date = null;
            $next_end_date = null;
            $fertile_start = null;
            $fertile_end = null;
        }

        return view('calendars.index', [
            'calendars' => $calendars,
            'events' => $events,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'cyclelength' => $cyclelength,
            'periodlength' => $periodlength,
            'next_start_date' => $next_start_date,
            'next_end_date' => $next_end_date,
            'fertile_start' => $fertile_start,
            'fertile_end' => $fertile_end,
        ]);
    }

    public function create(): View
    {
        return view('calendars.create');
    }

    public function store(Request $request): RedirectResponse|View
    {
        $this->validate($request, [
            'start_date' => 'required|date_format:d-m-Y',
            // hapus validasi end_date karena dihitung otomatis
            'cyclelength' => 'required|integer|min:1',
            'periodlength' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cycleLength = (int) $request->cyclelength;
        $periodLength = (int) $request->periodlength;

        // Hitung end_date otomatis: start_date + periodlength - 1 hari
        $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->start_date);
        // $startDate = Carbon::parse($request->start_date);
        // $endDate = $startDate->copy()->addDays($request->periodlength - 1);
        $endDate = $startDate->copy()->addDays($periodLength - 1);

        // Kalau user login, simpan ke database
        if (Auth::check()) {
            $userId = Auth::id();

            // User login: simpan ke tabel `period_models`
            Calendar::create([
                'user_id' => $userId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'cyclelength' => $cycleLength,
                'periodlength' => $periodLength,
                'notes' => $request->notes,
            ]);
            
            return redirect()->route('calendars.index')->with('success', 'Prediksi berhasil disimpan.');
        }

        // Hitung tanggal prediksi berikutnya
        // $nextStartDate = $startDate->copy()->addDays($request->cyclelength);
        // $nextEndDate = $nextStartDate->copy()->addDays($request->periodlength - 1);
        $nextStartDate = $startDate->copy()->addDays($cycleLength);
        $nextEndDate = $nextStartDate->copy()->addDays($periodLength - 1);

        // Masa subur: biasanya 14 hari sebelum periode berikutnya
        $fertileStart = $nextStartDate->copy()->subDays(14);
        $fertileEnd = $fertileStart->copy()->addDays(4); // masa subur 5 hari

        // Kalau guest, cuma tampilkan hasil prediksi langsung (tanpa simpan)
        return view('guest.result', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'cyclelength' => $request->cyclelength,
            'periodlength' => $request->periodlength,
            'next_start_date' => $nextStartDate,
            'next_end_date' => $nextEndDate,
            'fertile_start' => $fertileStart,
            'fertile_end' => $fertileEnd,
        ]);

    }

    public function show($id): View
    {
        $calendar = Calendar::findOrFail($id);
        return view('calendars.show', compact('calendar'));
    }

    public function edit(string $id): View
    {
        $calendar = Calendar::findOrFail($id);
        return view('calendars.edit', compact('calendar'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            // hapus validasi end_date
            'cyclelength' => 'required|integer|min:1',
            'periodlength' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $calendar = Calendar::findOrFail($id);

        $userId = Auth::id();

        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($request->periodlength - 1)->format('Y-m-d');

        $calendar->update([
            'user_id' => $userId,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'cyclelength' => $request->cyclelength,
            'periodlength' => $request->periodlength,
            'notes' => $request->notes,
        ]);

        return redirect()->route('calendars.index')->with('success', 'Data menstruasi berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $calendar = Calendar::findOrFail($id);
        $calendar->delete();

        return redirect()->route('calendars.index')->with('success', 'Data menstruasi berhasil dihapus.');
    }
}
