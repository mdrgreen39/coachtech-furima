@extends ('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/auth-form.css') }}">
@endsection

@section('main')
<div class="main @if(request()->is('login') || request()->is('register') || request()->is('address')) main-range @endif">
    <h2 class=" auth-form__heading">
        ログイン
    </h2>
    <div class="auth-form">
        <form class="auth-form__form" action="/register" method="post" novalidate>
            @csrf
            <div class="auth-form__group">
                <label for="email" class="auth-form__group-label">メールアドレス</label>
                <input class="auth-form__group-input" type="email" name="email" id="email" value="{{ old('email') }}">
                <p class="error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="auth-form__group">
                <label for="password" class="auth-form__group-label">パスワード</label>
                <input class="auth-form__group-input" type="password" name="password" id="password">
                <p class="error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <button class="auth-form__btn btn" type="submit">ログインする</button>
        </form>
        <a href="/register" class="auth-form__link">会員登録はこちら</a>
    </div>
</div>
@endsection