@extends('layouts.app')

@section('title','住所変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<div class="address-container">

    <h2 class="address-title">住所の変更</h2>

    <form method="POST" action="{{ route('purchase.address.update', $item->id) }}" class="address-form">
        @csrf

        <div class="form-group">
            <label for="postcode" class="form-label">郵便番号</label>
            <input
                id="postcode"
                type="text"
                name="postcode"
                class="form-input"
                value="{{ $user->postcode }}"
            >
        </div>

        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input
                id="address"
                type="text"
                name="address"
                class="form-input"
                value="{{ $user->address }}"
            >
        </div>

        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input
                id="building"
                type="text"
                name="building"
                class="form-input"
                value="{{ $user->building }}"
            >
        </div>

        <button class="submit-button">更新する</button>

    </form>

</div>

@endsection