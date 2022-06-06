@extends('layouts.app')

@section('content')

    <section>

        <div id="js-news">
            <news :list_gn="{{ json_encode($list_gn)}}"></news>
        </div>

    </section>

@endsection




