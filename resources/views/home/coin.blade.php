@extends('layouts.app')

@section('content')

    <section>

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
