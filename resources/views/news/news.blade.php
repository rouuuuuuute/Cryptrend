@extends('layouts.app')

@section('title','仮想通貨ニュース')


@section('content')

    <section>

        <div id="js-news">
            <news :list_gn="{{ json_encode($list_gn)}}"></news>
        </div>

    </section>

@endsection




