@extends('layouts.app')

@section('content')

<h1>マイページ</h1>

{{-- プロフィール情報 --}}
<div>
    @if($user->profile_image)
    <img src="{{ asset('storage/' . $user->profile_image) }}" width="100">
    @endif
    <p>{{ $user->name }}</p>
    <a href="/mypage/edit">プロフィールを編集</a>
</div>

{{-- 出品した商品一覧 --}}
<h2>出品した商品</h2>
@forelse($items as $item)
<div>
    <a href="/item/{{ $item->id }}">{{ $item->name }}</a>
    <p>¥{{ number_format($item->price) }}</p>
</div>
@empty
<p>出品した商品はありません</p>
@endforelse

{{-- 購入した商品一覧 --}}
<h2>購入した商品</h2>
@forelse($purchases as $purchase)
<div>
    <a href="/item/{{ $purchase->item->id }}">{{ $purchase->item->name }}</a>
    <p>¥{{ number_format($purchase->amount) }}</p>
</div>
@empty
<p>購入した商品はありません</p>
@endforelse

{{-- マイリスト（いいねした商品） --}}
<h2>マイリスト</h2>
@forelse($likedItems as $item)
<div>
    <a href="/item/{{ $item->id }}">{{ $item->name }}</a>
    <p>¥{{ number_format($item->price) }}</p>
</div>
@empty
<p>いいねした商品はありません</p>
@endforelse

@endsection