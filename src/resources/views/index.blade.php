@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="/css/index.css">
@endsection

@section('content')

{{-- タブ --}}
<div class="item-tab">
    <a href="/?tab=recommend&search={{ request('search') }}" class="item-tab__link {{ $tab === 'recommend' ? 'item-tab__link--active' : '' }}">おすすめ</a>
    @auth
    <a href="/?tab=mylist&search={{ request('search') }}" class="item-tab__link {{ $tab === 'mylist' ? 'item-tab__link--active' : '' }}">マイリスト</a>
    @endauth
</div>

{{-- 商品一覧 --}}
<div class="item-list">
    @if($tab === 'recommend')
    @foreach($items as $item)
    <div class="item-list__item">
        <a class="item-list__link" href="/item/{{ $item->id }}">
            <div class="item-list__img-wrap">
                <img src="{{ str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" class="item-list__img">
                @if($item->status === 'sold')
                <div class="item-list__sold">Sold</div>
                @endif
            </div>
            <p class="item-list__name">{{ $item->name }}</p>
        </a>
        <p class="item-list__price">¥{{ number_format($item->price) }}</p>
    </div>
    @endforeach
    @else
    @forelse($likedItems as $item)
    <div class="item-list__item">
        <a class="item-list__link" href="/item/{{ $item->id }}">
            <div class="item-list__img-wrap">
                <img src="{{ asset('storage/' . $item->image) }}" class="item-list__img">
                @if($item->status === 'sold')
                <div class="item-list__sold">Sold</div>
                @endif
            </div>
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