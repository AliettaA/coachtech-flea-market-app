<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img class="header__logo-img" src="{{ asset('img/logo.png') }}" alt="COACHTECH">
            </a>
            <div class="header__search">
                <form class="header__search-form" method="GET" action="/">
                    <input class="header__search-input" type="text" name="search" value="{{ request('search') }}" placeholder="商品名で検索">
                    <input type="hidden" name="tab" value="{{ request('tab', 'recommend') }}">
                    <button class="header__search-btn" type="submit">検索</button>
                </form>
            </div>
            <nav class="header__nav">
                @auth
                <form class="header__nav-form" method="POST" action="/logout">
                    @csrf
                    <button class="header__nav-btn" type="submit">ログアウト</button>
                </form>
                <a class="header__nav-link" href="/mypage">マイページ</a>
                <a class="header__nav-link header__nav-link--sell" href="/sell">出品</a>
                @else
                <a class="header__nav-link" href="/login">ログイン</a>
                <a class="header__nav-link" href="/register">会員登録</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>
    @yield('js')
</body>

</html>