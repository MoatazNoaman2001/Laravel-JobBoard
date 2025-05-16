<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
class RouteServiceProvider extends ServiceProvider
{
  
    public const HOME = '/home';

    public static function redirectToHome()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->user_type === 'candidate') {
                return '/candidate/home';
            } elseif ($user->user_type === 'employer') {
                return '/employee/home';
            }
        }
        return self::HOME;
    }
   
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
