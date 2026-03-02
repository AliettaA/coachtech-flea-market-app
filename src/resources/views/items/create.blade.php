@extends('layouts.app')

@section('content')

<h1>商品出品</h1>

@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li style="color:red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="/sell" enctype="multipart/form-data">
    @csrf
    <div>
        <label>商品画像</label>
        <input type="file" name="image" accept="image/*">
    </div>
    <h2>商品の詳細</h2>
    <div>
        <label>カテゴリ</label>
        <select name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div>
        <label>商品の状態</label>
        <select name="condition_id">
            <option value="">選択してください</option>
            @foreach($conditions as $condition)
            <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                {{ $condition->name }}
            </option>
            @endforeach
        </select>
    </div>
    <h2>商品名と説明</h2>
    <div>
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name') }}">
    </div>
    <div>
        <label>ブランド名</label>
        <input type="text" name="brand" value="{{ old('brand') }}">
    </div>
    <div>
        <label>商品説明</label>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>
    <div>
        <label>価格</label>
        <input type="number" name="price" value="{{ old('price') }}">
    </div>
    <button type="submit">出品する</button>
</form>

@endsection