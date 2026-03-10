<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\LoginRequest;

use App\Http\Responses\LoginResponse;
use App\Http\Responses\RegisterResponse;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * サービス登録
     */
    public function register()
    {
        // ログイン後リダイレクト
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        // 会員登録後リダイレクト
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
    }

    /**
     * Fortify設定
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | Fortify View
        |--------------------------------------------------------------------------
        */

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        /*
        |--------------------------------------------------------------------------
        | ユーザー登録処理
        |--------------------------------------------------------------------------
        */

        Fortify::createUsersUsing(CreateNewUser::class);

        /*
        |--------------------------------------------------------------------------
        | ログインバリデーション
        |--------------------------------------------------------------------------
        */

        Fortify::authenticateUsing(function ($request) {

            // LoginRequestのバリデーションを実行
            Validator::make(
                $request->all(),
                (new LoginRequest())->rules(),
                (new LoginRequest())->messages()
            )->validate();

            // ユーザー取得
            $user = User::where('email', $request->email)->first();

            // パスワード確認
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });

        /*
        |--------------------------------------------------------------------------
        | リダイレクト設定
        |--------------------------------------------------------------------------
        */

        Fortify::redirects('login', '/');
        Fortify::redirects('email-verification', '/mypage/edit');
    }
}
