@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/show.css') }}">
@endsection

@section('content')

<div class="item-detail">
    <div class="item-detail__top">

        {{-- 左：商品画像 --}}
        <div class="item-detail__image-wrap">
            <img class="item-detail__image" src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            @if($item->isSoldOut())
            <div class="item-detail__sold">Sold</div>
            @endif
        </div>

        {{-- 右：全情報 --}}
        <div class="item-detail__info">
            <h1 class="item-detail__name">{{ $item->name }}</h1>
            <p class="item-detail__brand">{{ $item->brand }}</p>
            <p class="item-detail__price">¥{{ number_format($item->price) }}<span class="item-detail__tax">（税込）</span></p>

            {{-- いいね・コメント --}}
            <div class="item-detail__actions">
                @auth
                {{-- ログイン時：いいねボタン --}}
                @if($item->isLikedBy(auth()->user()))
                <form class="item-detail__like-form" method="POST" action="/like/{{ $item->id }}">
                    @csrf
                    @method('DELETE')
                    <button class="item-detail__like-btn item-detail__like-btn--active" type="submit">
                        <img class="item-detail__action-icon" src="{{ asset('img/heart_pink.png') }}">
                        {{ $item->likes->count() }}
                    </button>
                </form>
                @else
                <form class="item-detail__like-form" method="POST" action="/like/{{ $item->id }}">
                    @csrf
                    <button class="item-detail__like-btn" type="submit">
                        <img class="item-detail__action-icon" src="{{ asset('img/heart_emp.png') }}">
                        {{ $item->likes->count() }}
                    </button>
                </form>
                @endif
                @else
                {{-- 未ログイン時：いいね数表示のみ --}}
                <span class="item-detail__comment-count">
                    <img class="item-detail__action-icon" src="{{ asset('img/heart_emp.png') }}">
                    {{ $item->likes->count() }}
                </span>
                @endauth

                {{-- コメント数は常に表示 --}}
                <span class="item-detail__comment-count">
                    <img class="item-detail__action-icon" src="{{ asset('img/comment.png') }}">
                    {{ $item->comments->count() }}
                </span>
            </div>

            {{-- 購入ボタン --}}
            @auth
            @if(!$item->isSoldOut() && $item->user_id !== auth()->id())
            <a class="item-detail__buy-btn" href="/purchase/{{ $item->id }}">購入手続きへ</a>
            @endif
            @else
            <a class="item-detail__login-link" href="/login">ログインして購入する</a>
            @endauth

            {{-- 商品説明 --}}
            <h2 class="item-detail__section-title">商品説明</h2>
            <p class="item-detail__description">{{ $item->description }}</p>

            {{-- 商品情報 --}}
            <h2 class="item-detail__section-title">商品情報</h2>
            <div class="item-detail__meta">
                <div class="item-detail__meta-row">
                    <span class="item-detail__meta-label">カテゴリ</span>
                    <div class="item-detail__categories">
                        @foreach($item->categories as $category)
                        <span class="item-detail__category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="item-detail__meta-row">
                    <span class="item-detail__meta-label">商品の状態</span>
                    <span class="item-detail__meta-value">{{ $item->condition->name ?? '-' }}</span>
                </div>
            </div>

            {{-- コメント一覧 --}}
            <div class="item-detail__comments">
                <h2 class="item-detail__comments-heading">コメント ({{ $item->comments->count() }})</h2>
                @foreach($item->comments as $comment)
                <div class="item-detail__comment">
                    <div class="item-detail__comment-user-wrap">
                        @if($comment->user->profile_image)
                        <img class="item-detail__comment-avatar" src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="{{ $comment->user->name }}">
                        @else
                        <div class="item-detail__comment-avatar-placeholder"></div>
                        @endif
                        <p class="item-detail__comment-user">{{ $comment->user->name }}</p>
                    </div>
                    <p class="item-detail__comment-content">{{ $comment->content }}</p>
                </div>
                @endforeach
            </div>

            {{-- コメントフォーム --}}
            @auth
            <div class="item-detail__comment-form">
                <h2 class="item-detail__section-title">商品へのコメント</h2>
                @if ($errors->any())
                <ul class="item-detail__errors">
                    @foreach ($errors->all() as $error)
                    <li class="item-detail__error-item">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <form method="POST" action="/comment/{{ $item->id }}">
                    @csrf
                    <textarea class="item-detail__textarea" name="content" placeholder="コメントを入力してください">{{ old('content') }}</textarea>
                    <button class="item-detail__comment-btn" type="submit">コメントする</button>
                </form>
            </div>
            @else
            <div class="item-detail__comment-form">
                <h2 class="item-detail__section-title">商品へのコメント</h2>
                <textarea class="item-detail__textarea" placeholder="コメントを入力してください" disabled></textarea>
                <a class="item-detail__login-link" href="/login">ログインしてコメントする</a>
            </div>
            @endauth

        </div>
    </div>
</div>

@endsection