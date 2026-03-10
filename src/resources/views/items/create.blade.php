@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item/create.css') }}">
@endsection

@section('content')

<div class="exhibition-form">
    <h1 class="exhibition-form__heading">商品の出品</h1>

    @if ($errors->any())
    <ul class="exhibition-form__errors">
        @foreach ($errors->all() as $error)
        <li class="exhibition-form__error-item">{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form class="exhibition-form__form" method="POST" action="/sell" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="exhibition-form__image-group">
            <div class="exhibition-form__image-area" id="image-area">
                <img class="exhibition-form__image-preview" id="image-preview" src="" alt="">
                <label class="exhibition-form__image-label" for="image">
                    <span class="exhibition-form__image-btn" id="image-btn">画像を選択する</span>
                </label>
                <input class="exhibition-form__image-input" type="file" name="image" id="image" accept="image/*">
            </div>
            <p class="exhibition-form__error-message">@error('image'){{ $message }}@enderror</p>
        </div>

        {{-- 商品の詳細 --}}
        <div class="exhibition-form__section">
            <h2 class="exhibition-form__section-title">商品の詳細</h2>

            {{-- カテゴリ --}}
            <div class="exhibition-form__group">
                <label class="exhibition-form__label">カテゴリ</label>
                <div class="exhibition-form__categories">
                    @foreach($categories as $category)
                    <label class="exhibition-form__category-label">
                        <input class="exhibition-form__category-input" type="checkbox" name="category_id[]" value="{{ $category->id }}"
                            {{ is_array(old('category_id')) && in_array($category->id, old('category_id')) ? 'checked' : '' }}>
                        <span class="exhibition-form__category-btn">{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
                <p class="exhibition-form__error-message">@error('category_id'){{ $message }}@enderror</p>
            </div>

            {{-- 商品の状態 --}}
            <div class="exhibition-form__group">
                <label class="exhibition-form__label" for="condition_id">商品の状態</label>
                <select class="exhibition-form__select" name="condition_id" id="condition_id">
                    <option value="">選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                    @endforeach
                </select>
                <p class="exhibition-form__error-message">@error('condition_id'){{ $message }}@enderror</p>
            </div>
        </div>

        {{-- 商品名と説明 --}}
        <div class="exhibition-form__section">
            <h2 class="exhibition-form__section-title">商品名と説明</h2>

            <div class="exhibition-form__group">
                <label class="exhibition-form__label" for="name">商品名</label>
                <input class="exhibition-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
                <p class="exhibition-form__error-message">@error('name'){{ $message }}@enderror</p>
            </div>

            <div class="exhibition-form__group">
                <label class="exhibition-form__label" for="brand">ブランド名</label>
                <input class="exhibition-form__input" type="text" name="brand" id="brand" value="{{ old('brand') }}">
            </div>

            <div class="exhibition-form__group">
                <label class="exhibition-form__label" for="description">商品の説明</label>
                <textarea class="exhibition-form__textarea" name="description" id="description">{{ old('description') }}</textarea>
                <p class="exhibition-form__error-message">@error('description'){{ $message }}@enderror</p>
            </div>
        </div>

        {{-- 販売価格 --}}
        <div class="exhibition-form__section">
            <h2 class="exhibition-form__section-title">販売価格</h2>
            <div class="exhibition-form__group">
                <label class="exhibition-form__label" for="price">販売価格</label>
                <input class="exhibition-form__input" type="number" name="price" id="price" value="{{ old('price') }}">
                <p class="exhibition-form__error-message">@error('price'){{ $message }}@enderror</p>
            </div>
        </div>

        <button class="exhibition-form__btn" type="submit">出品する</button>
    </form>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                const btn = document.getElementById('image-btn');
                preview.src = e.target.result;
                preview.style.display = 'block';
                btn.textContent = '画像を変更する';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection