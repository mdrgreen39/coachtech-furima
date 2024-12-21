@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item-detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-detail flex center">
        <div class="item-detail__image-container">
            <img class="item-detail__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">
        </div>
        <div class="item-detail__info flex">
            <h1 class="item-detail__name">{{ $item->name }}</h1>
            <p class="item-detail__price">¥{{ number_format($item->price) }}(値段)</p>
            <div class="item-detail__rating flex align-items-center">
                <div class="rating-star">
                    <i class="fa-regular fa-star fa-xl {{ $isLiked ? 'fa-solid fa-star fa-xl' : 'fa-regular fa-star fa-xl' }}"
                        data-item-id="{{ $item->id }}"
                        data-is-liked="{{ $isLiked ? 'true' : 'false' }}"></i>
                    <span class="count" id="like-count-{{ $item->id }}">{{ $item->likes->count() }}</span>
                </div>
                <div class="rating-comment">
                    <a href="{{ route('items.comments.show', $item->id) }}">
                        <i class="fa-regular fa-comment fa-xl"></i>
                    </a>
                    <span class="count" id="comment-count">{{ $item->comments->count() }}</span> <!-- 初期値はDBから取得 -->

                </div>
            </div>
            @if ($item->isSold())
            <p class="result-message">この商品は売れました</p>
            @else
            <a href="{{ route('items.purchase', $item->id) }}" class="item-detail__buy-button btn">購入する</a>
            @endif

            @if (session('error'))
            <p class="error-message">{{ session('error') }}</p>
            @endif
            <div class="item-detail__description">
                <h2>商品説明</h2>
                <p>{!! nl2br(e($item->description)) !!}</p>
            </div>
            <div class="item-detail__details">
                <h2>商品の情報</h2>
                <ul>
                    <li>
                        <strong>カテゴリー</strong>
                        @foreach ($item->categories as $category)
                        <span class="category-span">{{ $category->name }}</span>
                        @endforeach
                    </li>
                    <li>
                        <strong>商品の状態</strong>
                        <span class="condition-span">{{ $item->condition->condition }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="search-results" style="display:none;">

    </div>

</div>
@endsection