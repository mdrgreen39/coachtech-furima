@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

@endsection

@section('main')
<div class="main">
    <div id="mypage-profile-area" class="mypage-profile__image flex align-items-center">
        <div class="mypage-profile__image-display flex center">
            @if ($profile->image)
            <img class="mypage-profile__image-display--preview"
                id="mypage-image-preview"
                src="{{ Storage::url($profile->image) }}" alt="プロフィール画像">
            @else
            <div class="mypage-profile__image--icon flex align-items-center center">
                <i class="fa fa-camera"></i>
            </div>
            @endif
        </div>
        <h2 class="mypage-profile__user-name">{{$user->name ?? 'ユーザー名' }}</h2>
        <a href="{{ route('mypage.profile.edit') }}" class="mypage-profile__edit-btn edit-btn">
            プロフィールを編集
        </a>
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