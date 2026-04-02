@extends('layouts.app')

@section('title','マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-container">

    <div class="mypage-profile">

        <div class="profile-left">
            <div class="profile-image">
                <img class="user-icon-img"
                    src="{{ !empty($user->profile_image)
                        ? asset('storage/' . $user->profile_image)
                        : asset('images/default.jpeg') }}">
            </div>
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

    <a href="{{ route('items.show', $item->id) }}" class="item-card">

        <div class="item-image">

            @if($item->purchase !== null)
            <span class="sold-label">Sold</span>
            @endif

            <img class="item-img" src="{{ Str::startsWith($item->image, 'http')
            ? $item->image
            : asset('storage/' . $item->image) }}">
        </div>

        <p class="item-name">{{ $item->name }}</p>

    </a>

    @endforeach

</div>

@endsection