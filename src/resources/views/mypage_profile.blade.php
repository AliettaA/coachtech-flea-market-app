@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage_profile.css')}}">
@endsection

@section('search')
<form action="/search" method="GET" class="search-form">
    <input type="text" name="keyword" placeholder="なにをお探しですか？">
</form>
@endsection

@section('link')
<form action="{{ route('logout') }}" method="post">
    @csrf
    <input class="header__link-logout" type="submit" value="logout">
</form>
<a class="header__link-mypage" href="/my_page">マイページ</a>
<a href="" class="header__link-sell" href="/sell">出品</a>
@endsection

@section('content')
<div class="profile-form">
    <h2 class="profile-form__heading content__heading">会員登録</h2>
    <div class="profile-form__inner">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <input type="text" name="name" value="{{ $user->name }}">
            <input type="text" name="post_code" value="{{ $user->post_code }}">
            <input type="text" name="address" value="{{ $user->address }}">
            <input type="text" name="building" value="{{ $user->building }}">

            <button type="submit">更新する</button>
        </form>
    </div>
</div>
@endsection