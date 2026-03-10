@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase/confirm.css') }}">
@endsection

@section('content')

<div class="purchase">
    <form class="purchase__form" method="POST" action="/purchase/{{ $item->id }}">
        @csrf

        <div class="purchase__left">

            {{-- 商品情報 --}}
            <div class="purchase__item-info">
                <img class="purchase__item-img" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                <div class="purchase__item-detail">
                    <p class="purchase__item-name">{{ $item->name }}</p>
                    <p class="purchase__item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <hr class="purchase__border">

            {{-- 支払い方法 --}}
            <div class="purchase__section">
                <h2 class="purchase__section-title">支払い方法</h2>
                @if ($errors->any())
                <ul class="purchase__errors">
                    @foreach ($errors->all() as $error)
                    <li class="purchase__error-item">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                <select class="purchase__select" name="payment_method" id="payment_method">
                    <option value="">選択してください</option>
                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>クレジットカード</option>
                    <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                </select>
            </div>

            <hr class="purchase__border">

            {{-- 配送先 --}}
            <div class="purchase__section">
                <div class="purchase__section-header">
                    <h2 class="purchase__section-title">配送先</h2>
                    <a class="purchase__change-link" href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
                <p class="purchase__address">〒{{ $user->postal_code }}</p>
                <p class="purchase__address">{{ $user->address }} {{ $user->building }}</p>
            </div>

            <hr class="purchase__border">

        </div>

        {{-- 右列 --}}
        <div class="purchase__right">
            <div class="purchase__summary">
                <div class="purchase__summary-row">
                    <span class="purchase__summary-label">商品代金</span>
                    <span class="purchase__summary-value">¥{{ number_format($item->price) }}</span>
                </div>
                <div class="purchase__summary-row">
                    <span class="purchase__summary-label">支払い方法</span>
                    <span class="purchase__summary-value" id="selected-payment">-</span>
                </div>
            </div>
            <button class="purchase__btn" type="submit">購入する</button>
        </div>

    </form>
</div>

@endsection

@section('js')
<script>
    const select = document.getElementById('payment_method');
    const selectedPayment = document.getElementById('selected-payment');

    const paymentLabels = {
        'credit_card': 'クレジットカード',
        'convenience': 'コンビニ払い',
    };

    select.addEventListener('change', function() {
        selectedPayment.textContent = paymentLabels[this.value] || '-';
    });
</script>
@endsection