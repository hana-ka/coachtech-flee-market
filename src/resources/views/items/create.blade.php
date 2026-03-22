@extends('layouts.app')

@section('title','商品出品')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')

<div class="sell-container">

    <h2 class="sell-title">商品の出品</h2>

    <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="sell-form">
        @csrf

        {{-- =========================
        商品画像
        ========================= --}}
        <div class="form-group">
            <p class="form-label">商品画像</p>

            <div class="image-box">
                <input type="file" name="image" class="form-file">
                <button type="button" class="image-button">画像を選択する</button>
            </div>
        </div>


        {{-- =========================
        商品の詳細
        ========================= --}}
        <div class="form-section">

            <h3 class="section-title">商品の詳細</h3>

            {{-- カテゴリ --}}
            <p class="form-label">カテゴリー</p>

            <div class="category-list">

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="1">
                    <span class="category-text">ファッション</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="2">
                    <span class="category-text">家電</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="3">
                    <span class="category-text">インテリア</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="4">
                    <span class="category-text">レディース</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="5">
                    <span class="category-text">メンズ</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="6">
                    <span class="category-text">コスメ</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="7">
                    <span class="category-text">本</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="8">
                    <span class="category-text">ゲーム</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="9">
                    <span class="category-text">スポーツ</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="10">
                    <span class="category-text">キッチン</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="11">
                    <span class="category-text">ハンドメイド</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="12">
                    <span class="category-text">アクセサリー</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="13">
                    <span class="category-text">おもちゃ</span>
                </label>

                <label class="category-tag">
                    <input class="category-checkbox" type="checkbox" name="categories[]" value="14">
                    <span class="category-text">ベビー・キッズ</span>
                </label>

            </div>

            {{-- 状態 --}}
            <p class="form-label">商品の状態</p>

            <select name="condition_id" class="form-select">
                <option value="">選択してください</option>
                <option value="1">良好</option>
                <option value="2">目立った傷や汚れなし</option>
                <option value="3">やや傷や汚れあり</option>
                <option value="4">状態が悪い</option>
            </select>

        </div>


        {{-- =========================
        商品名と説明
        ========================= --}}
        <div class="form-section">

            <h3 class="section-title">商品名と説明</h3>

            <div class="form-group">
                <label for="name" class="form-label">商品名</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    class="form-input"
                >
            </div>

            <div class="form-group">
                <label for="brand" class="form-label">ブランド名</label>
                <input
                    id="brand"
                    type="text"
                    name="brand"
                    class="form-input"
                >
            </div>

            <div class="form-group">
                <label for="description" class="form-label">商品の説明</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                ></textarea>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">販売価格</label>
                <input
                    id="price"
                    type="number"
                    name="price"
                    class="form-input"
                    min="0"
                    placeholder="¥"
                >
            </div>

        </div>


        {{-- =========================
        ボタン
        ========================= --}}
        <button type="submit" class="sell-submit-button">
            出品する
        </button>

    </form>

</div>

@endsection