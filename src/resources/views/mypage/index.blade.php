@extends('layouts.app')

@section('title','マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-container">

    <div class="mypage-profile">

        <div class="profile-left">
            <div class="profile-image"></div>
            <p class="profile-name">{{ Auth::user()->name }}</p>
        </div>

        <a href="/mypage/profile" class="profile-edit-button">
            プロフィールを編集
        </a>

    </div>
</div>


<div class="mypage-tabs">

    <a href="/mypage" class="tab {{ request('page') !== 'buy' ? 'active' : '' }}">
        出品した商品
    </a>

    <a href="/mypage?page=buy" class="tab {{ request('page') === 'buy' ? 'active' : '' }}">
        購入した商品
    </a>

</div>




<div class="mypage-items">

    @foreach($items ?? [] as $item)

    <div class="item-card">

        <div class="item-image"></div>

        <p class="item-name">商品名</p>

    </div>

    @endforeach

</div>


@endsection