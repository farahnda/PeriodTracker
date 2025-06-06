<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Article;
use App\Notifications\PeriodNotification;
use Carbon\Carbon;
use Illuminate\Support\Str;

class KirimNotifikasiPeriodTracker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifikasi:kirim';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim semua jenis notifikasi Period Tracker';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $users = User::all();

        foreach ($users as $user) {
            if (!$user->last_period_date || !$user->cycle_length) continue;

            $last = Carbon::parse($user->last_period_date);
            $next = $last->copy()->addDays($user->cycle_length);
            $masaSubur = $next->copy()->subDays(14);

            // 1. Menjelang Hari Perkiraan Menstruasi (3 hari sebelum)
            if ($today->diffInDays($next) == 3 && $today->lt($next)) {
                $user->notify(new PeriodNotification(
                    'Pengingat Menstruasi',
                    'Siklus menstruasimu diperkirakan dimulai dalam 3 hari.'
                ));
            }

            // 2. Hari Pertama Menstruasi (berdasarkan prediksi)
            if ($today->equalTo($next)) {
                $user->notify(new PeriodNotification(
                    'Hari Pertama Menstruasi',
                    'Hari ini kemungkinan adalah hari pertama menstruasimu.'
                ));
            }

            // 3. Masa Subur (14 hari sebelum haid)
            if ($today->equalTo($masaSubur)) {
                $user->notify(new PeriodNotification(
                    'Masa Subur Telah Tiba',
                    'Kamu sedang memasuki masa subur. Jaga kesehatan dan perencanaan dengan bijak.'
                ));
            }

            // 4. Pengingat Input Data jika lebih dari 35 hari belum update
            if ($last->diffInDays($today) > 35) {
                $user->notify(new PeriodNotification(
                    'Yuk Catat Siklusmu',
                    'Sudah lebih dari 35 hari sejak kamu terakhir mencatat menstruasi. Yuk update sekarang!'
                ));
            }
        }

        // 5. Notifikasi Custom: Artikel baru dari admin
        $articles = Article::where('send_notification', true)->get();
        foreach ($articles as $article) {
            foreach ($users as $user) {
                $user->notify(new PeriodNotification(
                    'Artikel Baru: ' . $article->title,
                    Str::limit(strip_tags($article->content), 100)
                ));
            }
            $article->send_notification = false;
            $article->save();
        }

        $this->info('Semua notifikasi dikirim.');
    }
}
