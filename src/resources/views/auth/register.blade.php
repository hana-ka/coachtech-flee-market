@extends('layouts.auth')

@section('title','会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')

<div class="auth-container">

    <h1 class="auth-title">会員登録</h1>

    <form method="POST" action="{{ route('register') }}" class="auth-form" novalidate>
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">ユーザー名</label>
            <input
                id="name"
                type="text"
                name="name"
                class="form-input"
                value="{{ old('name') }}"
            >
        </div>

        @error('name')
        <p class="error">{{ $message }}</p>
        @enderror


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


        <div class="form-group">
            <label for="password_confirmation" class="form-label">確認用パスワード</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-input"
            >
        </div>


        <button type="submit" class="auth-button">
            登録する
        </button>

    </form>

    <p class="auth-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </p>

</div>

@endsection