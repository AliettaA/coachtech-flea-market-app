<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // ユーザー登録アクション
        $this->app->singleton(
            \Laravel\Fortify\Contracts\CreatesNewUsers::class,
            CreateNewUser::class
        );

        // 登録時のバリデーションをFormRequestに差し替え
        Fortify::registerView(fn() => view('auth.register'));
        Fortify::loginView(fn() => view('auth.login'));

        // 登録バリデーション
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::verifyEmailView(fn() => view('auth.verify-email'));
    }
}
