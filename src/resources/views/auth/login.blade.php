@extends('layouts.auth')

@section('title','ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')

<div class="auth-container">

    <h1 class="auth-title">ログイン</h1>

    <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-input"
                value="{{ old('email') }}"
            >
        </div>

        @error('email')
        <p class="error">{{ $message }}</p>
        @enderror


        <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-input"
            >
        </div>

        @error('password')
        <p class="error">{{ $message }}</p>
        @enderror


        <button type="submit" class="auth-button">
            ログインする
        </button>

    </form>

    <p class="auth-link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </p>

</div>

@endsection