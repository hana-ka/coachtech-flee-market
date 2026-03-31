@extends('layouts.auth')

@section('title', 'メール認証')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')

<div class="verify-wrapper">

    <div class="verify-box">

        <p class="verify-text">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <div class="verify-btn-area">
            <a href="http://localhost:8025" target="_blank" class="verify-btn">
            認証はこちらから
            </a>
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="resend-link">
                認証メールを再送する
            </button>
        </form>

    </div>

</div>

@endsection