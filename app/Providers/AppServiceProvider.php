<?php

namespace App\Providers;
use App\Models\Student;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
           
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = $user->notifications;
                $view->with('notifications', $notifications);
            }
        });
    }

    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
}
