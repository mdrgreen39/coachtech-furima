@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item-detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-detail flex">
        <div class="item-detail__image-container">
            <img class="item-detail__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">
        </div>
        <div class="item-detail__info">
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
                    <a href="" class="fa-regular fa-comment fa-xl"></a>
                    <span class="count" id="comment-count">0</span>
                </div>
            </div>
            <button class="item-detail__buy-button btn">購入する</button>
            <div class="item-detail__description">
                <h2>商品説明</h2>
                <p>{!! nl2br(e($item->description)) !!}</p>
            </div>
            <div class="item-detail__details">
                <h2>商品の情報</h2>
                <ul>
                    <li>カテゴリー: {{ $item->category->name }}</li>
                    <li>商品の状態: {{ $item->condition->name }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="search-results" style="display:none;">

    </div>
</div>
@endsection