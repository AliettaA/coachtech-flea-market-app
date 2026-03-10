<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css')}}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
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
        <div class="login-form">
            <h2 class="login-form__heading">ログイン</h2>
            <div class="login-form__inner">
                <form class="login-form__form" action="/login" method="post" novalidate>
                    @csrf
                    <div class="login-form__group">
                        <label class="login-form__label" for="email">メールアドレス</label>
                        <input class="login-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                        <p class="login-form__error-message">
                            @error('email'){{ $message }}@enderror
                        </p>
                    </div>
                    <div class="login-form__group">
                        <label class="login-form__label" for="password">パスワード</label>
                        <input class="login-form__input" type="password" name="password" id="password">
                        <p class="login-form__error-message">
                            @error('password'){{ $message }}@enderror
                        </p>
                    </div>
                    <input class="login-form__btn" type="submit" value="ログインする">
                    <a class="login-form__register-link" href="{{ route('register') }}">会員登録はこちら</a>
                </form>
            </div>
        </div>
    </main>
</body>

</html>