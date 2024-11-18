<header>
    <div class="header flex align-items-center @if(request()->is('login') || request()->is('register') || request()->is('address')) fixed-height @endif">
        @if(request()->is('login') || request()->is('register'))
        <a href="/">
            <img class="header-logo" src="/img/logo.svg" alt="logo">
        </a>
        @else
        @auth
        <a href="/">
            <img class="header-logo" src="/img/logo.svg" alt="logo">
        </a>
        <div class="flex align-items-center">
            <form id="search-form" action="{{ route('search.json') }}" method="GET">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request()->input('keyword') }}">
            </form>
            <x-hamburger-menu />
            <x-menu />
        </div>
        <nav class="header-nav">
            <ul class="flex align-items-center">
                <li class="header-nav__item">
                    <form action="/logout" method="post" novalidate>
                        @csrf
                        <button class="header-nav__item-btn--link" type="submit">ログアウト</button>
                    </form>
                </li>
                <li class="header-nav__item"><a href="">マイページ</a></li>
                <li class="header-nav__item-link--btn"><a href="">出品</a></li>
            </ul>
        </nav>
        @else
        <img class="header-logo" src="/img/logo.svg" alt="logo">
        <div class="flex align-items-center">
            <form id="search-form" action="{{ route('search.json') }}" method="GET">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request()->input('keyword') }}">
            </form>
            <x-hamburger-menu />
            <x-menu />
        </div>
        <nav class="header-nav">
            <ul class="flex align-items-center">
                <li class="header-nav__item"><a href="/login">ログイン</a></li>
                <li class="header-nav__item"><a href="/register">会員登録</a></li>
                <li class="header-nav__item-link--btn"><a href="">出品</a></li>
            </ul>
        </nav>
        @endauth
        @endif
    </div>

    @if (session('message'))
    <div class="flash-message">
        {{ session('message') }}
    </div>
    @endif

</header>