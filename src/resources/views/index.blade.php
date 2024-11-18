@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-list">
        <ul class="item-tabs">
            <li class="item-tab">
                <a href="{{ route('home', ['tab' => 'recommend']) }}"
                    class="item-link {{ request('tab') === 'recommend' ? 'active' : '' }}">おすすめ</a>
            </li>
            <li class="item-tab">
                <a href="{{ route('home', ['tab' => 'wishlist']) }}"
                    class="item-link {{ request('tab') === 'wishlist' ? 'active' : '' }}">マイリスト</a>
            </li>
        </ul>

        @include('components.item_grid', ['items' => $items])

        <div id="search-results" style="display:none;">
            @include('components.item_grid', ['items' => $items])
        </div>
    </div>
</div>
@endsection