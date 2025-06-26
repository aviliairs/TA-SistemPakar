<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (auth()->check() && !session()->has('user_profile')) {
                $user = auth()->user();
                session([
                    'user_profile' => [
                        'id' => $user->id_user,
                        'nama' => $user->nama,
                        'email' => $user->email,
                        'avatar' => $user->profile_picture ?? null,
                        'jenis_kelamin' => $user->jenis_kelamin ?? null,
                    ]
                ]);
            }
        });
    }
}
