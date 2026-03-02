@extends('layouts.app')

@section('content')

<h1>商品購入</h1>

<h2>商品情報</h2>
<p>{{ $item->name }}</p>
<p>¥{{ number_format($item->price) }}</p>

<h2>配送先</h2>
<p>〒{{ $user->postal_code }}</p>
<p>{{ $user->address }} {{ $user->building }}</p>
<a href="/purchase/{{ $item->id }}/address">配送先を変更する</a>

@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li style="color:red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="/purchase/{{ $item->id }}">
    @csrf
    <div>
        <label>支払い方法</label>
        <select name="payment_method">
            <option value="">選択してください</option>
            <option value="credit_card">クレジットカード</option>
            <option value="convenience">コンビニ払い</option>
            <option value="bank_transfer">銀行振込</option>
        </select>
    </div>
    <button type="submit">購入する</button>
</form>

@endsection