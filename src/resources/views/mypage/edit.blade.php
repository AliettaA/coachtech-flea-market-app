@extends('layouts.app')

@section('content')

<h1>プロフィール編集</h1>

@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li style="color:red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="/mypage/edit" enctype="multipart/form-data">
    @csrf
    <div>
        <label>プロフィール画像</label>
        @if($user->profile_image)
        <img src="{{ asset('storage/' . $user->profile_image) }}" width="100">
        @endif
        <input type="file" name="profile_image" accept="image/*">
    </div>
    <div>
        <label>名前</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}">
    </div>
    <div>
        <label>郵便番号</label>
        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="123-4567">
    </div>
    <div>
        <label>住所</label>
        <input type="text" name="address" value="{{ old('address', $user->address) }}">
    </div>
    <div>
        <label>建物名</label>
        <input type="text" name="building" value="{{ old('building', $user->building) }}">
    </div>
    <button type="submit">更新する</button>
</form>

@endsection