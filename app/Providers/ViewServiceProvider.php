
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Membagikan $unreadCount ke semua view yang memakai 'layouts.nav'
        View::composer('layouts.nav', function ($view) {
            $unreadCount = 0;
            if (Auth::check()) {
                $unreadCount = Auth::user()->unreadNotifications()->count();
            }
            $view->with('unreadCount', $unreadCount);
        });
    }

    public function register()
    {
        //
    }
}
