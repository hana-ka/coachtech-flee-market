@extends('layouts.app')

@section('title','商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<div class="purchase-container">

    <div class="purchase-inner">

        <div class="purchase-left">

            <div class="purchase-item">

                <div class="item-image">
                    @if(Str::startsWith($item->image, 'http'))
                        <img class="item-image-img" src="{{ $item->image }}">
                    @else
                        <img class="item-image-img" src="{{ asset('storage/' . $item->image) }}">
                    @endif
                </div>

                <div class="item-info">
                    <p class="item-name">{{ $item->name }}</p>
                    <p class="item-price">¥{{ number_format($item->price) }}</p>
                </div>

            </div>

            <form method="GET">

                <div class="purchase-section">

                    <p class="section-title">支払い方法</p>

                    <select name="payment_method" onchange="this.form.submit()" class="form-select">

                        <option value="" disabled selected hidden>選択してください</option>

                        <option value="convenience"
                            {{ request('payment_method') === 'convenience' ? 'selected' : '' }}>
                            コンビニ支払い
                        </option>

                        <option value="card"
                            {{ request('payment_method') === 'card' ? 'selected' : '' }}>
                            カード支払い
                        </option>

                    </select>

                </div>

            </form>

            <div class="purchase-section">

                <div class="section-header">
                    <p class="section-title">配送先</p>
                    <a href="{{ route('purchase.address.edit', $item->id) }}" class="change-link">変更する</a>
                </div>

                <p class="address">
                    〒{{ $user->postcode }}
                </p>

                <p class="address">
                    {{ $user->address }} {{ $user->building }}
                </p>

            </div>

        </div>


        <form method="POST" action="{{ route('purchase.store', $item->id) }}">
            @csrf

            <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
            <input type="hidden" name="postcode" value="{{ $user->postcode }}">
            <input type="hidden" name="address" value="{{ $user->address }}">
            <input type="hidden" name="building" value="{{ $user->building }}">

            <div class="purchase-right">

                <div class="purchase-summary">

                    <div class="summary-row">
                        <p class="summary-label">商品代金</p>
                        <p class="summary-value">¥{{ number_format($item->price) }}</p>
                    </div>

                    <div class="summary-row">
                        <p class="summary-label">支払い方法</p>
                        <p class="summary-value">
                            @if(request('payment_method') === 'convenience')
                                コンビニ支払い
                            @elseif(request('payment_method') === 'card')
                                カード支払い
                            @else
                                未選択
                            @endif
                        </p>
                    </div>

                </div>

                <button type="submit" class="submit-button">
                    購入する
                </button>

            </div>

        </form>

    </div>

</div>

@endsection