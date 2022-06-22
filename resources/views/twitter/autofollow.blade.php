@extends('layouts.app')

@section('title','一括フォロー')

@section('content')

    <section>
    @if (session('user_token'))

        @if (session('today_follow_end'))
            <!--セッション情報にtoday_follow_endが入っている場合、本日のフォローができない。-->

                <div class="p-desc__container">
                    <p class="p-desc__text c-text">
                        本日はすでに多くのフォローを実施しているため、フォローは実施できません。<br>
                        明日以降アクセスしてください。<br>
                    </p>
                    <div class="u-short"></div>

                    <!--ユーザーのツイッター情報がないので、管理者の引っ張ってきた情報を見本として表示-->
                    <div id="js-nologin">
                        <nologin
                            autofollowsample_ajax="{{ url('/twitterautofollow/sampleindex') }}">
                        </nologin>
                    </div>
                </div>
        @else
            <!--ツイッター認証をしている場合は下記コンポーネントを表示。受け渡す変数の内容は以下の通りです。-->
                <!--autofollow_checkはセッションの状態。1ならば自動フォロー実施中。-->
                <!--users_resultsはログインユーザーがフォローしてないユーザー一覧のスクリーンネーム。-->
                <!--autofollow_ajaxは個別フォローするurlへのポストの時のurl-->
                <!--autofollowall_ajaxは自動フォローをonにするポストのurl-->
                <!--$autofollow_checkこの値で現在オートフォロー中か判断-->
                <div id="js-twitter">
                    <twitter
                        :users_results="{{ $users_results }}"
                        follow_users="{{$follow_users}}"
                        autofollow_check="{{ $autofollow_check }}"
                        autofollow_ajax="{{ url('/twitter/autofollow/follow') }}"
                        autofollowall_ajax="{{ url('/twitter/autofollow/all') }}"
                    >
                    </twitter>
                </div>
        @endif

    @else
        <!--ツイッター認証をしていない場合は下記を表示-->
            <div class="c-text p-twiiter__top">
                <p>各アカウントのフォローをするには<br>「Twitter認証」をしてください。</p>
                <a href="/twitter/accounts" class="">Twitter認証を行う。</a>
            </div>

            <!--ユーザーのツイッター情報がないので、情報を見本としてコンポーネントで表示-->
            <!--autofollowsample_ajaxは、DBから取得するためのajax用の変数-->
            <div id="js-nologin">
                <nologin
                    autofollowsample_ajax="{{ url('/twitterautofollow/sampleindex') }}"
                ></nologin>
            </div>
        @endif
    </section>

@endsection
