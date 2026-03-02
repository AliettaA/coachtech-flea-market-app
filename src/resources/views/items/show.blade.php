@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="/css/index.css">
@endsection

@section('content')

<h1>{{ $item->name }}</h1>
<p>¥{{ number_format($item->price) }}</p>
<p>{{ $item->description }}</p>

{{-- いいね数・コメント数 --}}
<p>❤️ {{ $item->likes->count() }}　💬 {{ $item->comments->count() }}</p>

@auth
@if($item->isLikedBy(auth()->user()))
<form method="POST" action="/like/{{ $item->id }}">
    @csrf
    @method('DELETE')
    <button type="submit">❤️ いいね済み</button>
</form>
@else
<form method="POST" action="/like/{{ $item->id }}">
    @csrf
    <button type="submit">🤍 いいね</button>
</form>
@endif

@if(!$item->isSoldOut() && $item->user_id !== auth()->id())
<a href="/purchase/{{ $item->id }}">購入する</a>
@endif
@endauth

{{-- コメント一覧 --}}
<h2>コメント ({{ $item->comments->count() }})</h2>
@foreach($item->comments as $comment)
<div>
    <p><strong>{{ $comment->user->name }}</strong></p>
    <p>{{ $comment->content }}</p>
</div>
@endforeach

{{-- コメントフォーム --}}
@auth
@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li style="color:red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="/comment/{{ $item->id }}">
    @csrf
    <textarea name="content" placeholder="コメントを入力してください">{{ old('content') }}</textarea>
    <button type="submit">コメントする</button>
</form>
@endauth

@endsection