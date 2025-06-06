protected function schedule(Schedule $schedule)
{
    $schedule->command('notifikasi:kirim')->daily();
}
