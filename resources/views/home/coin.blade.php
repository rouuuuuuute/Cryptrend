@extends('layouts.app')

@section('content')

    <section>
    <div class="p-desc__container">
        <h2 class="p-desc__title c-text">
            <i class="fas fa-coins"></i>通貨トレンド
        </h2>
        <p class="p-desc__text c-text">
            Twitter上の各コインのツイート数をカウントしました。<br>
            いつ、どのコインが話題になっているか？コインのトレンドを確認しましょう。<br>
        </p>
    </div>
    <div class="u-mark__small">※過去1時間/1日/1週間単位で集計しています。</div>

    <!--コントローラーから持ってきたデータ。-->
    <!--coin_ajaxはcoinのデータを取得するためのajaxに使うURL。-->
    <!--hour,day,weekはそれぞれ期間分のツイート数を取得したもの。-->

    <div id="js-coin">
        <coin
            coin_ajax="{{ url('ajax/coin') }}"
            hour = "{{$hour}}"
            day = "{{$day}}"
            week = "{{$week}}"
        >
        </coin>
    </div>
    </section>


@endsection
