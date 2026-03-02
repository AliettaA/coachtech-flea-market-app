@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="/css/index.css">
@endsection

@section('content')

{{-- タブ --}}
<div class="item-tab">
    <a href="/?tab=recommend" class="item-tab__link {{ $tab === 'recommend' ? 'item-tab__link--active' : '' }}">おすすめ</a>
    @auth
    <a href="/?tab=mylist" class="item-tab__link {{ $tab === 'mylist' ? 'item-tab__link--active' : '' }}">マイリスト</a>
    @endauth
</div>

{{-- 商品一覧 --}}
<div class="item-list">
    @if($tab === 'recommend')
    @foreach($items as $item)
    <div class="item-list__item">
        <a href="/item/{{ $item->id }}">
            <img src="{{ $item->image }}" class="item-list__img">
            <p class="item-list__name">{{ $item->name }}</p>
        </a>
        <p class="item-list__price">¥{{ number_format($item->price) }}</p>
    </div>
    @endforeach
    @else
    @forelse($likedItems as $item)
    <div class="item-list__item">
        <a href="/item/{{ $item->id }}">
            <img src="{{ $item->image }}" class="item-list__img">
            <p class="item-list__name">{{ $item->name }}</p>
        </a>
        <p class="item-list__price">¥{{ number_format($item->price) }}</p>
    </div>
    @empty
    <p>いいねした商品はありません</p>
    @endforelse
    @endif
</div>

@endsection