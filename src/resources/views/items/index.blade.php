@extends('layouts.app')

@section('title','商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')

<div class="items-tabs">
    <div class="items-container">

        <div class="tabs">

            <a href="/" class="tab {{ request('tab') !== 'mylist' ? 'active' : '' }}">
                おすすめ
            </a>

            <a href="/?tab=mylist{{ request('keyword') ? '&keyword=' . request('keyword') : '' }}" class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
                マイリスト
            </a>

        </div>

    </div>
</div>

<div class="items-container">

    <div class="items-grid">

        @foreach($items ?? [] as $item)

        <a href="/item/{{ $item->id }}" class="item-card">

            <div class="item-image">

                @if(Str::startsWith($item->image, 'http'))
                    <img src="{{ $item->image }}">
                @else
                    <img src="{{ asset('storage/' . $item->image) }}">
                @endif

                @if($item->purchase !== null)
                    <span class="sold-label">Sold</span>
                @endif

            </div>

            <p class="item-name">
                {{ $item->name }}
            </p>

        </a>

        @endforeach

    </div>

</div>

@endsection