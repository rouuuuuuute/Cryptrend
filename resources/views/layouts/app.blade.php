<!doctype html>
<!-- 親テンプレートを作成 -->

<!--言語を取得と'-'の置き換え-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <!-- レスポンシブデザインの準備 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 子テンプレートでsection('title')があるかどうかで表示をわけている -->
    @hasSection('title')
        <title>@yield('title') | CryptoTrend</title>
    @else
        <title>{{ config('app.name') }}</title>
@endif

<!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700;900&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
<!-- ヘッダーのテンプレート -->
@section('header')
    <header id="l-header">
        <h1 class="c-title"><a class="c-menu__link" href="/welcome">仮想通貨トレンド分析システム|CryptoTrend</a></h1>
        <div class="c-menu__sp js-toggle-sp-menu">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <nav class="js-toggle-sp-menu-target">
            <ul class="c-menu">
                @if (Route::has('register'))
                    @auth
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                             href="{{ route('autofollow.index') }}"
                            >一括フォロー</a></li>
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                             href="{{ route('home.index') }}"
                            >仮想通貨トレンド</a></li>
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                             href="{{ route('news.index') }}">仮想通貨ニュース</a>
                        </li>
                        <li class="c-menu__sidebar js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                                href="{{ route('twitter.accounts') }}">Twitterアカウント登録</a>
                        </li>
                        <li class="c-menu__item js-toggle-sp-menu-target">
                            <a class="c-menu__link" href="{{ route('home.profile') }}">マイページ</a></li>
                        <div>
                            <li class="c-menu__item js-toggle-sp-menu-target">
                                <a class="c-menu__link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('ログアウト') }}
                                </a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>

                    @else
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                             href="/welcome">{{ __('TOP') }}</a></li>
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                             href="{{ route('register') }}">{{ __('まずは無料登録') }}</a>
                        </li>
                        <li class="c-menu__item js-toggle-sp-menu-target"><a class="c-menu__link"
                                                                             href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </nav>
    </header>
@show

@if ( session ('flash_message'))
    <div class="c-arelt" role="alert">
        <p>{{ session ('flash_message')}}</p>
    </div>
@endif

<main id="l-main">
    @yield('content')
    @yield('sidebar')
</main>


<!-- フッターのテンプレート -->
@section('footer')
    <footer id="l-footer">
        <div class="p-footer">
            <p>Copyright ©CryptoTrend. All Rights Reserved</p>
        </div>
    </footer>
@show

<!-- Scripts -->
<script src="{{ asset('js/bundle.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    $(function () {
        // SPメニュー
        $('.js-toggle-sp-menu').on('click', function () {
            $(this).toggleClass('active');
            $('.js-toggle-sp-menu-target').toggleClass('active');
        });

        $('.js-toggle-sp-menu-target').on('click', function () {
            $(this).toggleClass('active');
        });
    });
</script>

</body>

</html>
