@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('main')
<div class="main">
    <h2 class="profile-upload__heading">プロフィール設定</h2>
    <div class="profile-upload">
        <form class="profile-upload__form" action="" method="post" novalidate>
            @csrf
            <div class="profile-upload__image flex align-items-center">
                <div class="profile-upload__image-display">
                    <img class="profile-upload__image-display--preview" id="image-preview" src="#">
                </div>

                <label for="image" class="profile-upload__image-label">
                    <input class="profile-upload__image-input edit-btn" type="file" id="image" name="image" accept="image/*" onchange="">
                    画像を選択する
                </label>

                <p class="error-message">

                </p>
            </div>
            <div class="profile-upload__group">
                <label for="name" class="profile-upload__group-label">ユーザー名</label>
                <input class="profile-upload__group-input" type="text" name="name" id="name" value="{{ old('name') }}">
                <p class="error-message">

                </p>
            </div>

            @include('components.address-field')

            <button class="profile-upload__btn btn" type="submit">更新する</button>
        </form>
    </div>


</div>
@endsection