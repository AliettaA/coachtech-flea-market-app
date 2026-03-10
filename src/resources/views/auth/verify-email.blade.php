<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証 | COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css')}}">
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css')}}">
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
        <div class="verify">
            <div class="verify__message">
                <p class="verify__text">登録していただいたメールアドレスに認証メールを送付しました。</p>
                <p class="verify__text">メール認証を完了してください。</p>
                <a class="verify__btn" href="http://localhost:8025" target="_blank">認証はこちらから</a>
                <form class="verify__form" method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button class="verify__btn verify__btn--resend" type="submit">認証メールを再送する</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>