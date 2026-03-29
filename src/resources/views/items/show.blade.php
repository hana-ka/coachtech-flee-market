@extends('layouts.app')

@section('title','商品詳細')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')

<div class="item-detail-container">

    <div class="item-detail-image">
        @if(Str::startsWith($item->image, 'http'))
            <img class="item-detail-img" src="{{ $item->image }}">
        @else
            <img class="item-detail-img" src="{{ asset('storage/' . $item->image) }}">
        @endif
    </div>

    <div class="item-detail-content">

        <h2 class="item-name">{{ $item->name }}</h2>

        <p class="item-brand">{{ $item->brand }}</p>

        <p class="item-price">
            ¥{{ number_format($item->price) }}(税込)
        </p>


        <div class="item-icons">

            <div class="like-box">
                @auth
                    <form method="POST" action="/like/{{ $item->id }}">
                        @csrf
                        <button type="submit" class="like-button">
                            @php
                                $isLiked = $item->likes->contains('user_id', Auth::id());
                            @endphp

                            <img
                                class="icon-img"
                                src="{{ $isLiked ? asset('images/icon-heart-pink.png') : asset('images/icon-heart.png') }}"
                            >
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">
                        <img class="icon-img" src="{{ asset('images/icon-heart.png') }}">
                    </a>
                @endauth

                <span class="icon-count">{{ $item->likes->count() }}</span>
            </div>

            <div class="comment-box">
                <img class="icon-img" src="{{ asset('images/icon-comment.png') }}">
                <span class="icon-count">{{ $item->comments->count() }}</span>
            </div>

        </div>


        <a href="/purchase/{{ $item->id }}" class="purchase-button">
            購入手続きへ
        </a>


        <div class="item-description">
            <h3 class="section-title">商品説明</h3>
            <p class="description-text">{{ $item->description }}</p>
        </div>


        <div class="item-info">
            <h3 class="section-title">商品の情報</h3>

            <p class="info-text">
                カテゴリ
                @foreach($item->categories as $category)
                    <span class="category-name">{{ $category->name }}</span>
                @endforeach
            </p>

            <p class="info-text">
                商品の状態
                <span class="condition-name">{{ $item->condition->name }}</span>
            </p>
        </div>


        <div class="item-comments">

            <h3 class="section-title">コメント  ({{ $item->comments->count() }})</h3>

            <div class="comment-list">

                @foreach($item->comments as $comment)

                    <div class="comment-item">

                        <div class="comment-user">
                            <div class="comment-user-icon">
                            @if($comment->user->profile_image)
                                <img
                                    class="user-icon-img"
                                    src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                >
                            @else
                                <img
                                    class="user-icon-img"
                                    src="{{ asset('images/default.jpeg') }}"
                                >
                            @endif
                        </div>
                            <p class="comment-user-name">
                                {{ $comment->user->name }}
                            </p>
                        </div>

                        <p class="comment-text">
                            {{ $comment->content }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>


        <form method="POST" action="{{ route('comments.store', $item->id) }}" class="comment-form">
            @csrf

            <p class="comment-label">商品へのコメント</p>

            <textarea name="content" class="comment-textarea"></textarea>

            <button class="comment-button">
                コメントを送信する
            </button>
        </form>


    </div>

</div>

@endsection