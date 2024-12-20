@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}
">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="main">
    <div class="item-detail flex center">
        <div class="profile-upload-container">
            <h2 class="profile-upload__heading">プロフィール設定</h2>
            <div class="profile-upload">
                <form class="profile-upload__form" action="{{ route('mypage.profile.update') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="profile-upload__image flex align-items-center">
                        <div class="profile-upload__image-display  flex center">
                            <img class="profile-upload__image-display--preview" id="image-preview"
                                src="{{ $profile->image ? Storage::url($profile->image) : '' }}"
                                alt="プロフィール画像"
                                style="display: {{ $profile->image ? 'block' : 'none' }};">

                            @if (!$profile->image)
                            <div class="profile-upload__image--icon flex align-items-center center">
                                <i class="fa fa-camera"></i>
                            </div>
                            @endif
                        </div>

                        <label for="image" class="profile-upload__image-label">
                            <input class="profile-upload__image-input edit-btn" type="file" id="image" name="image" accept="image/*">
                            画像を選択する
                        </label>
                        @if ($errors->has('image'))
                        <p class="error-message">{{ $errors->first('image') }}</p>
                        @endif
                    </div>
                    <div class="profile-upload__group">
                        <label for="name" class="profile-upload__group-label">ユーザー名</label>
                        <input class="profile-upload__group-input" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}">
                        @if ($errors->has('name'))
                        <p class="error-message">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    @include('components.address-field')

                    <button class="profile-upload__btn btn" type="submit">更新する</button>
                </form>
            </div>

        </div>



    </div>
    <div id="search-results" style="display:none;">

    </div>



</div>
@endsection