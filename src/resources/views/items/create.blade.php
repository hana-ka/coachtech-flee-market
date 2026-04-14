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

        <div class="form-group">
            <p class="form-label">商品画像</p>

            <div class="image-box">
                <label class="image-button">
                    画像を選択する
                    <input
                        type="file"
                        name="image"
                        class="form-file"
                    >
                </label>
            </div>

            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-section">

            <h3 class="section-title">商品の詳細</h3>

            <p class="form-label">カテゴリー</p>

            <div class="category-list">

                @foreach($categories as $category)
                    <label class="category-tag">
                        <input
                            class="category-checkbox"
                            type="checkbox"
                            name="categories[]"
                            value="{{ $category->id }}"
                        >
                        <span class="category-text">
                            {{ $category->name }}
                        </span>
                    </label>
                @endforeach

            </div>

            @error('categories')
                <p class="error">{{ $message }}</p>
            @enderror

            <p class="form-label">商品の状態</p>

            <select name="condition_id" class="form-select">
                <option value="" disabled selected hidden>選択してください</option>

                @foreach($conditions as $condition)
                    <option value="{{ $condition->id }}">
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>

            @error('condition_id')
                <p class="error">{{ $message }}</p>
            @enderror

        </div>


        <div class="form-section">

            <h3 class="section-title">商品名と説明</h3>

            <div class="form-group">
                <label for="name" class="form-label">商品名</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input"
                >
            </div>

            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="brand" class="form-label">ブランド名</label>
                <input
                    id="brand"
                    type="text"
                    name="brand"
                    value="{{ old('brand') }}"
                    class="form-input"
                >
            </div>

            <div class="form-group">
                <label for="description" class="form-label">商品の説明</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                >{{ old('description') }}</textarea>
            </div>

            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="form-group">
                <label for="price" class="form-label">販売価格</label>
                <div class="price-input">
                    <span class="yen">¥</span>
                    <input
                    id="price"
                    type="number"
                    name="price"
                    value="{{ old('price') }}"
                    class="form-input"
                    min="0"
                    >
                </div>
            </div>

            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror

        </div>


        <button type="submit" class="sell-submit-button">
            出品する
        </button>

    </form>

</div>

@endsection