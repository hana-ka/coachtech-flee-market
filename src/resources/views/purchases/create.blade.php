@extends('layouts.app')

@section('title','商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

<div class="purchase-container">

    <div class="purchase-inner">

        {{-- 左側 --}}
        <div class="purchase-left">

            {{-- 商品 --}}
            <div class="purchase-item">

                <div class="item-image"></div>

                <div class="item-info">
                    <p class="item-name">{{ $item->name }}</p>
                    <p class="item-price">¥{{ number_format($item->price) }}</p>
                </div>

            </div>


            {{-- 支払い方法 --}}
            <div class="purchase-section">

                <p class="section-title">支払い方法</p>

                <select class="form-select">
                    <option>選択してください</option>
                    <option>コンビニ支払い</option>
                    <option>カード支払い</option>
                </select>

            </div>


            {{-- 配送先 --}}
            <div class="purchase-section">

                <div class="section-header">
                    <p class="section-title">配送先</p>
                    <a href="{{ route('purchase.address.edit', $item->id) }}" class="change-link">変更する</a>
                </div>

                <p class="address">
                    〒{{ $user->postcode ?? 'XXX-YYYY' }}
                </p>

                <p class="address">
                    {{ $user->address ?? 'ここには住所と建物が入ります' }}
                </p>

            </div>

        </div>


        {{-- 右側 --}}
        <div class="purchase-right">

            <div class="purchase-summary">

                <div class="summary-row">
                    <p class="summary-label">商品代金</p>
                    <p class="summary-value">¥{{ number_format($item->price) }}</p>
                </div>

                <div class="summary-row">
                    <p class="summary-label">支払い方法</p>
                    <p class="summary-value">コンビニ払い</p>
                </div>

            </div>

            <button class="submit-button">
                購入する
            </button>

        </div>

    </div>

</div>

@endsection