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

        // Data untuk FullCalendar
        $events = $calendars->map(function ($item) {
    return [
        'title' => 'Menstruasi',
        'start' => $item->start_date,
        'end' => Carbon::parse($item->end_date)->addDay()->toDateString(), // end exclusive
        'color' => 'red',
    ];
});


        $last = $calendars->sortByDesc('start_date')->first();

        $nextPeriod = $last
            ? Carbon::parse($last->start_date)->addDays($last->cyclelength)->format('Y-m-d')
            : null;

        $fertileStart = $last
            ? Carbon::parse($last->start_date)->addDays(14)->format('Y-m-d')
            : null;

        return view('calendars.index', [
            'calendars' => $calendars,
            'events' => $events,
            'nextPeriod' => $nextPeriod,
            'fertileWindow' => $fertileStart,
        ]);
    }

    public function create(): View
    {
        return view('calendars.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'start_date' => 'required|date',
            // hapus validasi end_date karena dihitung otomatis
            'cyclelength' => 'required|integer|min:1',
            'periodlength' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();

        // Hitung end_date otomatis: start_date + periodlength - 1 hari
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($request->periodlength - 1)->format('Y-m-d');

        Calendar::create([
            'user_id' => $userId,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'cyclelength' => $request->cyclelength,
            'periodlength' => $request->periodlength,
            'notes' => $request->notes,
        ]);

        return redirect()->route('calendars.index')->with('success', 'Data menstruasi berhasil disimpan.');
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
