@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css')}}">
@endsection

@section('content')
<div class="content">
    <div class="message">
        <p>登録していただいたメールアドレスに認証メールを送付しました。</p>
        <p>メール認証を完了してください。</p>

        <button class="go-to-verify">認証はこちらから</button>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="resend-button" type="submit">認証メールを再送する</button>
        </form>
    </div>
</div>
    @endsection