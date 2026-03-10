@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/mypage.css') }}">
@endsection

@section('content')

<div class="profile">

    {{-- プロフィール情報 --}}
    <div class="profile__header">
        <div class="profile__user">
            @if($user->profile_image)
            <img class="profile__avatar" src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
            @else
            <div class="profile__avatar-placeholder"></div>
            @endif
            <p class="profile__name">{{ $user->name }}</p>
        </div>
        <a class="profile__edit-btn" href="/mypage/profile">プロフィールを編集</a>
    </div>

    {{-- タブ --}}
    <div class="profile__tab">
        <a class="profile__tab-link {{ $page === 'sell' ? 'profile__tab-link--active' : '' }}" href="/mypage?page=sell">出品した商品</a>
        <a class="profile__tab-link {{ $page === 'buy' ? 'profile__tab-link--active' : '' }}" href="/mypage?page=buy">購入した商品</a>
    </div>

    {{-- 商品一覧 --}}
    <div class="profile__item-list">
        @if($page === 'sell')
        @forelse($items as $item)
        <div class="profile__item">
            <a class="profile__item-link" href="/item/{{ $item->id }}">
                <img class="profile__item-img" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                <p class="profile__item-name">{{ $item->name }}</p>
            </a>
            <p class="profile__item-price">¥{{ number_format($item->price) }}</p>
        </div>
        @empty
        <p class="profile__empty">出品した商品はありません</p>
        @endforelse
        @else
        @forelse($purchases as $purchase)
        <div class="profile__item">
            <a class="profile__item-link" href="/item/{{ $purchase->item->id }}">
                <img class="profile__item-img" src="{{ asset('storage/' . $purchase->item->image) }}" alt="{{ $purchase->item->name }}">
                <p class="profile__item-name">{{ $purchase->item->name }}</p>
            </a>
            <p class="profile__item-price">¥{{ number_format($purchase->amount) }}</p>
        </div>
        @empty
        <p class="profile__empty">購入した商品はありません</p>
        @endforelse
        @endif
    </div>

</div>

@endsection