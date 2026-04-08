@extends('layouts.app')

@section('title','プロフィール設定')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="profile-container">

    <h2 class="profile-title">プロフィール設定</h2>

    <form method="POST" action="{{ route('mypage.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- 画像 --}}
        <div class="profile-image-area">

            <div class="profile-image">
                @if($user->image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}">
                @else
                    <img src="{{ asset('images/default.jpeg') }}">
                @endif
            </div>

            <label class="image-button">
                画像を選択する
                <input type="file" name="image">
            </label>

        </div>

        {{-- ユーザー名 --}}
        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}">
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button class="profile-button">
            更新する
        </button>

    </form>

</div>

@endsection