@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

@endsection

@section('main')
<div class="main">
    <div id="profile-upload-image" class="profile-upload__image flex align-items-center">
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
    <div class="item-tabs-wrapper">
        <ul class="item-tabs flex">
            <li class="item-tab">
                <a href="#" class="item-link {{ $currentTab === 'recommend' ? 'active' : '' }}" data-tab="recommend">出品した商品</a>
            </li>
            <li class="item-tab">
                <a href="#" class="item-link {{ $currentTab === 'purchase' ? 'active' : '' }}" data-tab="purchase">購入した商品</a>
            </li>
        </ul>
    </div>
    <div id="items-list">
        @include('components.item-grid', ['items' => $items])
    </div>
    <div id="search-results" style="display:none;">

    </div>
</div>
@endsection