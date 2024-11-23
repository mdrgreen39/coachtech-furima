@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-tabs-wrapper">
        <ul class="item-tabs flex">
            <li class="item-tab">
                <a href="#" class="item-link {{ $currentTab === 'recommend' ? 'active' : '' }}" data-tab="recommend">おすすめ</a>
            </li>
            <li class="item-tab">
                <a href="#" class="item-link {{ $currentTab === 'wishlist' ? 'active' : '' }}" data-tab="wishlist">マイリスト</a>
            </li>
        </ul>
    </div>
    <div id="items-list">
        @include('components.item-grid', ['items' => $items])
    </div>

    <div id="search-results" style="display:none;">
        @include('components.item-grid', ['items' => $items])
    </div>
</div>
@endsection