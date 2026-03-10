<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録 | COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css')}}">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img class="header__logo-img" src="{{ asset('img/logo.png') }}" alt="COACHTECH">
            </a>
        </div>
    </header>

    <main class="main">
        <div class="register-form">
            <h2 class="register-form__heading">会員登録</h2>
            <div class="register-form__inner">
                <form class="register-form__form" action="/register" method="post" novalidate>
                    @csrf
                    <div class="register-form__group">
                        <label class="register-form__label" for="name">ユーザー名</label>
                        <input class="register-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
                        <p class="register-form__error-message">
                            @error('name'){{ $message }}@enderror
                        </p>
                    </div>
                    <div class="register-form__group">
                        <label class="register-form__label" for="email">メールアドレス</label>
                        <input class="register-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                        <p class="register-form__error-message">
                            @error('email'){{ $message }}@enderror
                        </p>
                    </div>
                    <div class="register-form__group">
                        <label class="register-form__label" for="password">パスワード</label>
                        <input class="register-form__input" type="password" name="password" id="password">
                        <p class="register-form__error-message">
                            @error('password'){{ $message }}@enderror
                        </p>
                    </div>
                    <div class="register-form__group">
                        <label class="register-form__label" for="password_confirmation">確認用パスワード</label>
                        <input class="register-form__input" type="password" name="password_confirmation" id="password_confirmation">
                        <p class="register-form__error-message"></p>
                    </div>
                    <input class="register-form__btn" type="submit" value="登録する">
                    <a class="register-form__login-link" href="{{ route('login') }}">ログインはこちら</a>
                </form>
            </div>
        </div>
    </main>
</body>

</html>