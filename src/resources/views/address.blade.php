@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('main')
<div class="main">
    <h2 class="profile-upload__heading">住所の変更</h2>
    <div class="profile-upload">
        <form class="profile-upload__form" action="" method="post" novalidate>
            @csrf

            @include('components.address-field')

            <button class="profile-upload__btn btn" type="submit">更新する</button>
        </form>
    </div>
</div>
@endsection