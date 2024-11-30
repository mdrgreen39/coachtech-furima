<div id="menu" class="menu">
    @if( Auth::check() )
    <form action="/logout" method="post" novalidate>
        @csrf
        <button class="menu__item-btn--link" type="submit">ログアウト</button>
    </form>
    <a href="{{ route('user.mypage') }}" class="menu__item">マイページ</a>
    <a class="menu__item-link--btn" href="">出品</a>
    @else
    <a href="/login" class="menu__item">ログイン</a>
    <a href="/register" class="menu__item">会員登録</a>
    <a class="menu__item-link--btn" href="">出品</a>
    @endif
</div>