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
                    'title' => 'Menstruasi',
                    'className' => 'menstruation-day', 
                ];
                $startDate->addDay(); 
            }

            if ($item->next_start_date && $item->next_end_date) {
                $nextStartDate = Carbon::parse($item->next_start_date);
                $nextEndDate = Carbon::parse($item->next_end_date);

                while ($nextStartDate->lte($nextEndDate)) {
                    $eventDays[] = [
                        'start' => $nextStartDate->toDateString(),
                        'end' => $nextStartDate->toDateString(),
                        'title' => 'Next Menstruation',
                        'className' => 'next-day', 
                    ];
                    $nextStartDate->addDay(); 
                }
            }

            if ($item->fertile_start_date && $item->fertile_end_date) {
                $fertileStartDate = Carbon::parse($item->fertile_start_date);
                $fertileEndDate = Carbon::parse($item->fertile_end_date);

                while ($fertileStartDate->lte($fertileEndDate)) {
                    $eventDays[] = [
                        'start' => $fertileStartDate->toDateString(),
                        'end' => $fertileStartDate->toDateString(),
                        'title' => 'Masa Subur',
                        'className' => 'fertile-day',
                    ];
                    $fertileStartDate->addDay();
                }
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
            $fertile_start_date = $next_start_date->copy()->subDays(15);
            $fertile_end_date = $fertile_start_date->copy()->addDays(4);
        } else {
            $next_start_date = null;
            $next_end_date = null;
            $fertile_start_date = null;
            $fertile_end_date = null;
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
            'fertile_start_date' => $fertile_start_date,
            'fertile_end_date' => $fertile_end_date,
            'last' => $last,
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
            'cyclelength' => 'required|integer|min:1',
            'periodlength' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cycleLength = (int) $request->cyclelength;
        $periodLength = (int) $request->periodlength;
        $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $endDate = $startDate->copy()->addDays($periodLength - 1);

        $nextStartDate = $startDate->copy()->addDays($cycleLength);
        $nextEndDate = $nextStartDate->copy()->addDays($periodLength - 1);
        $fertileStartDate = $nextStartDate->copy()->subDays(15);
        $fertileEndDate = $fertileStartDate->copy()->addDays(4);

        if (Auth::check()) {
            $userId = Auth::id();

            Calendar::create([
                'user_id' => $userId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'cyclelength' => $cycleLength,
                'periodlength' => $periodLength,
                'next_start_date' => $nextStartDate,
                'next_end_date' => $nextEndDate,
                'fertile_start_date' => $fertileStartDate,
                'fertile_end_date' => $fertileEndDate,
                'notes' => $request->notes,
            ]);

            return redirect()->route('calendars.index')->with('success', 'Prediksi berhasil disimpan.');
        }

        // Guest logic: generate events (tanpa menyimpan ke database)
        $events = [];

        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $events[] = [
                'start' => $current->toDateString(),
                'end' => $current->toDateString(),
                'title' => 'Menstruasi',
                'className' => 'menstruation-day',
            ];
            $current->addDay();
        }

        $current = $nextStartDate->copy();
        while ($current->lte($nextEndDate)) {
            $events[] = [
                'start' => $current->toDateString(),
                'end' => $current->toDateString(),
                'title' => 'Next Menstruation',
                'className' => 'next-day',
            ];
            $current->addDay();
        }

        $current = $fertileStartDate->copy();
        while ($current->lte($fertileEndDate)) {
            $events[] = [
                'start' => $current->toDateString(),
                'end' => $current->toDateString(),
                'title' => 'Masa Subur',
                'className' => 'fertile-day',
            ];
            $current->addDay();
        }

        return view('guest.result', [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'cyclelength' => $request->cyclelength,
            'periodlength' => $request->periodlength,
            'next_start_date' => $nextStartDate,
            'next_end_date' => $nextEndDate,
            'fertile_start_date' => $fertileStartDate,
            'fertile_end_date' => $fertileEndDate,
            'events' => $events,
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
            'start_date' => 'required|date_format:d-m-Y',
            // 'end_date' => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'cyclelength' => 'required|integer|min:1',
            'periodlength' => 'required|integer|min:1',
        ]);

        $calendar = Calendar::findOrFail($id);

        $userId = Auth::id();

        $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date);
        $periodLength = (int) $request->periodlength;
        $cycleLength = (int) $request->cyclelength;

        $endDate = $startDate->copy()->addDays($periodLength - 1);
        $nextStartDate = $startDate->copy()->addDays($cycleLength);
        $nextEndDate = $nextStartDate->copy()->addDays($periodLength - 1);
        $fertileStartDate = $nextStartDate->copy()->subDays(15);
        $fertileEndDate = $fertileStartDate->copy()->addDays(4);

        $calendar->update([
            'user_id' => $userId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'cyclelength' => $request->cyclelength,
            'periodlength' => $request->periodlength,
            'next_start_date' => $nextStartDate,
            'next_end_date' => $nextEndDate,
            'fertile_start_date' => $fertileStartDate,
            'fertile_end_date' => $fertileEndDate,   
        ]);

        return redirect()->route('calendars.index')->with('success', 'Data menstruasi berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $calendar = Calendar::findOrFail($id);
        $calendar->delete();

        return redirect()->route('calendars.index')->with('success', 'Data prediksi berhasil dihapus.');
    }
}