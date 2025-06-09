<?php

namespace App\Console;

use App\Models\User;
use App\Notifications\NoPredictionInputNotification;
use App\Notifications\MenstruationReminderNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Period;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
{
    $schedule->call(function () {
        $today = Carbon::now()->startOfDay();

        $periods = \App\Models\Period::with('user')->get();

        foreach ($periods as $period) {
            $user = $period->user;
            $nextStart = Carbon::parse($period->next_start_date);
            $diff = $today->diffInDays($nextStart, false); // false untuk bisa negatif

            if ($diff === 7) {
                $user->notify(new MenstruationReminderNotification(
                    type: 'H-7',
                    title: 'H-7 Menstruasi',
                    body: 'Menstruasimu diperkirakan datang 7 hari lagi.'
                ));
            } elseif ($diff === 3) {
                $user->notify(new MenstruationReminderNotification(
                    type: 'H-3',
                    title: 'H-3 Menstruasi',
                    body: 'Menstruasimu diperkirakan datang 3 hari lagi.'
                ));
            } elseif ($diff === 1) {
                $user->notify(new MenstruationReminderNotification(
                    type: 'H-1',
                    title: 'H-1 Menstruasi',
                    body: 'Besok kamu akan menstruasi. Jaga kondisi tubuhmu ya.'
                ));
            } elseif ($diff === 0) {
                $user->notify(new MenstruationReminderNotification(
                    type: 'day_H',
                    title: 'Hari Pertama Menstruasi',
                    body: 'Hari ini kamu mulai menstruasi. Semangat menjalani hari!'
                ));
            }
        }
    })->dailyAt('08:00'); // Setiap hari jam 8 pagi
}
    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        // require base_path('routes/console.php'); // optional, kalau ada file console route
    }
}
