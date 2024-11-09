<header>
    <div class="header align-items-center flex">
        <x-hamburger-menu />
        @if(request()->path() == '/' || request()->path() == 'search')
        <x-search />
        @endif
    </div>
    @if (session('massage'))
    <div class="flash_message">
        {{ session('massage') }}
    </div>
    @endif

    <x-drowmenu />
</header>