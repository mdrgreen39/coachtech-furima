@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item-detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-detail flex center">
        <div class="item-detail__image-container">
            <img class="item-detail__image" src="{{ $item->image_url }}" alt="{{ $item->name }}">
        </div>
        <div class="item-detail__content flex">
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
                        <a href="" class="fa-regular fa-comment fa-xl"></a>
                        <span class="count" id="comment-count-{{ $item->id }}">{{ $item->comments->count() }}</span> <!-- 初期値はDBから取得 -->
                    </div>
                </div>
            </div>
            <div id="comments-section">
                <div class="comments-list">
                    @foreach ($item->comments as $comment)
                    <div class="comment-item">
                        <div class="comment-author flex align-items-center">
                            @if ($profileImageUrl)
                            <img class="comment-author__image" src="{{ $profileImageUrl }}" alt="プロフィール画像">
                            @else
                            <div class="comment-author__icon flex align-items-center center">
                                <i class="fa fa-camera"></i>
                            </div>
                            @endif

                            <strong>{{ $comment->user->name ?: '名前' }}</strong>
                        </div>
                        <p class="comment-text">{{ $comment->comment }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- コメントフォーム -->
                <div class="comment-form">
                    <form action="{{ route('items.comments.store', $item->id) }}" data-item-id="{{ $item->id }}" method="POST" novalidate>
                        @csrf

                        <div class="comment-form-group flex">
                            <label for="comment">商品へのコメント</label>
                            <textarea name="comment" id="comment" rows="5" class="comment-input" required></textarea>
                            @if ($errors->has('content'))
                            <p class="error-message">{{ $errors->first('content') }}</p>
                            @endif

                        </div>
                        <button class="item-detail__buy-button btn" type="submit">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="search-results" style="display:none;">

    </div>

</div>

@endsection