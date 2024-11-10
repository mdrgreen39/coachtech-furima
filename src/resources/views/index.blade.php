@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="link-group align-items-center flex">
        <a href="">おすすめ</a>
        <a href="">マイリスト</a>

    </div>
    <div class="flex wrap items">
        <div id="item-list">
            
        </div>

        <div id="search-results" style="display:none;"></div>

    </div>
</div>
@endsection