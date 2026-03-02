<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>

<body>
    {{-- ヘッダー --}}
    <header>
        <div class="header__inner">
            {{-- ロゴ --}}
            <a href="/"><img src="{{ asset('img/logo.png') }}" alt="COACHTECH"></a>

            {{-- 検索バー --}}
            <div class="header__search">
                <form method="GET" action="/">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="商品名で検索">
                    <button type="submit">検索</button>
                </form>
            </div>

            {{-- ナビゲーション --}}
            <nav class="header__nav">
                @auth
                <a href="/mypage">マイページ</a>
                <a href="/sell">出品</a>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
                @else
                <a href="/login">ログイン</a>
                <a href="/register">会員登録</a>
                @endauth
            </nav>
        </div>
    </header>
    @yield('content')
</body>