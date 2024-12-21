@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-detail flex center">
        <h2 class="profile-upload__heading">住所の変更</h2>
        <div class="profile-upload">
            <form class="profile-upload__form" action="{{ route('address.update', ['item_id' => $itemId]) }}" method="post" novalidate>
                @csrf

                @include('components.address-field')

                <button class="profile-upload__btn btn" type="submit">更新する</button>
            </form>
        </div>
    </div>
    <div id="search-results" style="display:none;">

    </div>

</div>
@endsection