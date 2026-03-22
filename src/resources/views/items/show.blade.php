@extends('layouts.app')

@section('title','商品詳細')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')

<div class="item-detail-container">

    {{-- 左：商品画像 --}}
    <div class="item-detail-image">
        <img src="{{ $item->image }}" alt="商品画像">
    </div>


    {{-- 右：商品情報 --}}
    <div class="item-detail-content">

        <h2 class="item-name">{{ $item->name }}</h2>

        <p class="item-brand">{{ $item->brand }}</p>

        <p class="item-price">
            ¥{{ number_format($item->price) }}(税込)
        </p>


        {{-- いいね・コメント --}}
        <div class="item-icons">

            <div class="icon-box">
                <img src="{{ asset('images/icon-heart.png') }}" alt="いいね">
                <span>0</span>
            </div>

            <div class="icon-box">
                <img src="{{ asset('images/icon-comment.png') }}" alt="コメント">
                <span>0</span>
            </div>

        </div>


        {{-- 購入ボタン --}}
        <a href="#" class="purchase-button">
            購入手続きへ
        </a>


        {{-- 商品説明 --}}
        <div class="item-description">
            <h3 class="section-title">商品説明</h3>
            <p class="description-text">{{ $item->description }}</p>
        </div>


        {{-- 商品情報 --}}
        <div class="item-info">
            <h3 class="section-title">商品の情報</h3>

            <p class="info-text">カテゴリ：---</p>
            <p class="info-text">商品の状態：---</p>

        </div>


        {{-- コメント --}}
        <div class="item-comments">

            <h3 class="section-title">コメント (0)</h3>

            <div class="comment">

                <div class="comment-user">
                    <div class="comment-user-icon"></div>
                    <p class="comment-user-name">ユーザー名</p>
                </div>

                <p class="comment-text">
                    コメント内容
                </p>

            </div>

        </div>


        {{-- コメント投稿（ログイン時のみ後で） --}}
        @auth
        <form class="comment-form">
            <p class="comment-label">商品へのコメント</p>
            <textarea  class="comment-textarea"></textarea>
            <button class="comment-button">コメントを送信する</button>
        </form>
        @endauth


    </div>

</div>

@endsection