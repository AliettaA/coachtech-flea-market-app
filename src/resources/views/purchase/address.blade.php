@extends('layouts.app')

@section('content')

<h1>配送先変更</h1>

@if ($errors->any())
<ul>
    @foreach ($errors->all() as $error)
    <li style="color:red;">{{ $error }}</li>
    @endforeach
</ul>
@endif

<form method="POST" action="/purchase/{{ $item->id }}/address" enctype="multipart/form-data">
    @csrf
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
    <button type="submit">変更する</button>
</form>

@endsection