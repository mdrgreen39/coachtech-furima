@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-list">
        <div class="profile-upload__image flex align-items-center">
            <div class="profile-upload__image-display">
                <img class="profile-upload__image-display--preview" id="image-preview" src="#">
            </div>
            <h2 class="">ユーザー名</h2>

            <label for="image" class="profile-upload__image-label">
                <input class="profile-upload__image-input edit-btn" type="file" id="image" name="image" accept="image/*" onchange="">
                画像を選択する
            </label>

            <p class="error-message">

            </p>
        </div>
        <ul class="item-tabs">
            <li class="item-tab">
                <a href="{{ route('home', ['tab' => 'recommend']) }}"
                    class="item-link {{ request('tab') === 'recommend' ? 'active' : '' }}">出品した商品</a>
            </li>
            <li class="item-tab">
                <a href="{{ route('home', ['tab' => 'wishlist']) }}"
                    class="item-link {{ request('tab') === 'wishlist' ? 'active' : '' }}">購入した商品</a>
            </li>
        </ul>

        @include('components.item_grid', ['items' => $items])

    </div>
</div>
@endsection