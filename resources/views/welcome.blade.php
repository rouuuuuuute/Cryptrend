@extends('layouts.app')

@section('title','情報収集にイノベーションを')

@section('header')
    @parent
@endsection

@section('content')
    <article id="l-main__article">
        <section class="p-top">
            <section class="p-top__msg">
                <div class="c-top">
                    <h1 class="c-top__theme">情報収集に”イノベーション”を</h1>
                    <img class="c-img__logo" src="{{ asset('images/logo-Twitter.png') }}" alt="">
                </div>
                <div class="c-top">
                    <p class="c-top__text">日本最大級のSNS利用者数を誇るTwitter</p>
                    <p class="c-top__text">匿名性・拡散性が高く</p>
                    <p class="c-top__text">リアルな情報が収集できる</p>
                    <p class="c-top__text">企業アカウント、インフルエンサー...etc</p>
                    <p class="c-top__text">あらゆる業種・職種が情報発信を始めている</p>
                    <p class="c-top__text">いま、最新の情報をあなたにも</p>
                </div>
                @if (Route::has('register'))
                    <div class="c-top">
                        @auth
                            <a class="c-button c-button__top c-menu__link" href="{{ route('home.profile') }}">マイページへ</a>
                        @else
                            <a class="c-button c-button__top  c-menu__link"
                               href="{{ route('register') }}">無料で情報を収集する</a>
                        @endauth
                    </div>
                @endif
            </section>
            <section class="p-top__img">
                <div class="c-img">
                    <img class="c-img__sp" src="{{ asset('images/top-sp.png') }}" alt="">
                </div>
                <div class="c-img">
                    <img class="c-img__arrow" src="{{ asset('images/top-arrow.png') }}" alt="">
                </div>
                <div class="c-img">
                    <img class="c-img__img" src="{{ asset('images/top-coin.png') }}" alt="">
                    <img class="c-img__human c-img__human--female" src="{{ asset('images/top-woman.png') }}" alt="">
                    <img class="c-img__img" src="{{ asset('images/top-news.png') }}" alt="">
                </div>
            </section>
        </section>
        <section class="p-prof">
            <section class="">
                <div class="c-top">
                    <h2 class="c-top__heading">CryptoTrendとは</h2>
                    <p class="c-top__text">Twitter社やGoogle社から提供されるデータを使って<br>仮想通貨に関するリアルタイムの情報を収集し<br>利用者の投資検討先に役立つツールです
                    </p>
                </div>
            </section>
            <section class="">
                <div class="c-top">
                    <h2 class="c-top__heading">こんなことで困っていませんか</h2>
                    <p class="c-top__text">仮想通貨に関するリアルタイムのニュースが欲しい</p>
                    <p class="c-top__text">仮想通貨に関するナマの声が聞きたい</p>
                    <p class="c-top__text">仮想通貨のトレンドを知りたい</p>
                    <p class="c-top__text">CryptoTrendなら解決できます！</p>
                </div>
            </section>
        </section>
        <section id="p-service">
            <section class="c-top">
                <div>
                    <h2 class="c-top__heading">サービス</h2>
                </div>
                <div class="c-card">
                    <div class="c-card__service">
                        <h3 class="c-card__title">一括フォロー</h3>
                        <p class="c-top__text">仮想通貨ユーザーを自動で検索</p>
                        <p class="c-top__text">自動でフォロー</p>
                        <p class="c-top__text">1日で最大1000人も<br>フォロワーが増えることも！？</p>
                    </div>
                    <div class="c-card__service">
                        <h3 class="c-card__title">仮想通貨トレンド</h3>
                        <p class="c-top__text">最新のつぶやきからトレンドを予想</p>
                        <p class="c-top__text">1時間前、1日前、1週間前の<br>つぶやき数を表示</p>
                        <p class="c-top__text">直近の評価額を知ることもでき</p>
                        <p class="c-top__text">いちはやく仮想通貨トレンドがわかる</p>
                    </div>
                    <div class="c-card__service">
                        <h3 class="c-card__title">仮想通貨ニュース</h3>
                        <p class="c-top__text">仮想通貨に関するニュースを収集</p>
                        <p class="c-top__text">記事一覧が１ページでまとまっている</p>
                        <p class="c-top__text">最新情報にいちはやくリーチしよう</p>
                    </div>
                </div>
            </section>

            @if (Route::has('register'))
                <section id="p-price" class="">
                    <div class="c-top">
                        @auth
                            <a class="c-top__heading" href="{{ route('home.profile') }}">マイページへ</a>
                        @else
                            <h2 class="c-top__heading">料金プラン</h2>
                            <p class="c-top__heading">いまなら月額無料！</p>
                            <a class="c-top__text" href="{{ route('register') }}">まずは無料登録へ</a>
                        @endauth
                    </div>
                    @endif
                </section>
        </section>
    </article>
@endsection



@section('footer')
    @parent
@endsection
