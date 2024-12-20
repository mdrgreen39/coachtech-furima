@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/auth-form.css') }}">
@endsection

@section('main')
<div class="main @if(request()->is('login') || request()->is('register') || request()->is('address')) main-range @endif">
    <h1 class="auth-form__heading">
        会員登録
    </h1>
    <div class="auth-form">
        <form class="auth-form__form" action="/register" method="post" novalidate>
            @csrf
            <div class="auth-form__group">
                <label for="email" class="auth-form__group-label">メールアドレス</label>
                <input class="auth-form__group-input" type="email" name="email" id="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                <p class="error-message">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="auth-form__group">
                <label for="password" class="auth-form__group-label">パスワード</label>
                <input class="auth-form__group-input" type="password" name="password" id="password">
                @if ($errors->has('password'))
                <p class="error-message">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <button class="auth-form__btn btn" type="submit">登録する</button>
        </form>
        <a href="/login" class="auth-form__link">ログインはこちら</a>
    </div>
</div>
@endsection