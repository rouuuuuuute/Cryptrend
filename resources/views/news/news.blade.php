@extends('layouts.app')

@section('content')

    <section>
    <div>
        <h2>仮想通貨ニュース一覧</h2>
        <p>Googleニュースより仮想通貨関連のニュースを抜粋しました。</p>
    </div>

    <div id="js-news">
        <news :list_gn="{{ json_encode($list_gn)}}"></news>
    </div>

    </section>

@endsection




