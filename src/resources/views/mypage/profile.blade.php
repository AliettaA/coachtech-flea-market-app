@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/profile.css')}}">
@endsection

@section('content')

<div class="profile-edit">
    <h1 class="profile-edit__heading">プロフィール設定</h1>

    <form class="profile-edit__form" method="POST" action="/mypage/profile" enctype="multipart/form-data">
        @csrf

        {{-- 画像エリア --}}
        <div class="profile-edit__image-group">
            @if($user->profile_image)
            <img class="profile-edit__image" id="profile-preview" src="{{ asset('storage/' . $user->profile_image) }}">
            @else
            <div class="profile-edit__image-placeholder" id="profile-placeholder"></div>
            <img class="profile-edit__image" id="profile-preview" src="" style="display:none;">
            @endif
            <label class="profile-edit__image-btn" for="profile_image">画像を編集する</label>
            <input class="profile-edit__file-input" type="file" name="profile_image" id="profile_image" accept="image/*">
        </div>

        {{-- 入力フィールド --}}
        <div class="profile-edit__group">
            <label class="profile-edit__label" for="name">ユーザー名</label>
            <input class="profile-edit__input" type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
            <p class="profile-edit__error-message">@error('name'){{ $message }}@enderror</p>
        </div>
        <div class="profile-edit__group">
            <label class="profile-edit__label" for="postal_code">郵便番号</label>
            <input class="profile-edit__input" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="123-4567">
            <p class="profile-edit__error-message">@error('postal_code'){{ $message }}@enderror</p>
        </div>
        <div class="profile-edit__group">
            <label class="profile-edit__label" for="address">住所</label>
            <input class="profile-edit__input" type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
            <p class="profile-edit__error-message">@error('address'){{ $message }}@enderror</p>
        </div>
        <div class="profile-edit__group">
            <label class="profile-edit__label" for="building">建物名</label>
            <input class="profile-edit__input" type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
        </div>

        <button class="profile-edit__btn" type="submit">更新する</button>
    </form>
</div>
@endsection

@section('js')
<script>
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profile-preview');
                const placeholder = document.getElementById('profile-placeholder');
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection