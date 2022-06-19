<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Services\LookupSearchService;
use App\Services\TwitterUserSearchService;
use App\Services\FollowingService;
use App\Autofollow;
use App\User;
use App\Updatetime;
use App\TwitterAccount;

//まとめてフォロー関連のクラス。
//twitteroauth でサービスへのログインユーザーのツイッター情報を取得する。
//index:まとめてフォローのページ表示/followはフォローの実施アクション/allfollowは自動フォローのONOFF切り替え機能
//autofollowは自動フォローをONにしているユーザーのみ、自動で14人フォローする
//addfollowでdbに定期的（日に一度）ツイッターから情報を取得し、仮想通貨関連のアカウントを取り込む。
//（それを元にindex側でアカウントを表示します。）


class AutofollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    //ーーーーーーーーーーオートフォロートップページーーーーーーーーーー
    //Sessionに'today_follow_end';が入っていると本日の本サービスでのフォローはできないようにします。(1日に395人以上を超えたら制限。)
    public function index()
    {

        Log::debug("ーーーーーーーーーーーーーーーまとめてフォローのページですーーーーーーーーーーーーーーー");
        $autofollow_flg = Auth::user()->autofollow;
        $autofollow_check = $autofollow_flg;
        Log::debug(print_r("autofollow_checkの状態", true));
        Log::debug(print_r($autofollow_flg, true));
        Log::debug(print_r("1だとオートフォローはon、0だとオートフォローはoff", true));
        Log::debug(print_r("セッション：autofollowを調整します", true));

        if ($autofollow_flg === 1) {
            Session::put('autofollow', true);//セッションにオートフォロー実施中である旨を入れる。
        } else {
            Session::forget('autofollow');
        }

        //■■■前回にフォローした日付（follow_day）をDBから確認し、違う日であればリセットする。■■■
        Log::debug(print_r("処理:DB上の前回のアクセス日と異なるかチェックします。", true));
        date_default_timezone_set('Asia/Tokyo');
        $today = date("Y-m-d");
        Log::debug(print_r("本日の日付" . $today, true));
        $dbfollow_day = Auth::user()->follow_day;
        Log::debug("DB上のフォローした日" . $dbfollow_day);

        //db上のフォローをした日付と本日が違う場合
        if ($today !== $dbfollow_day) {
            Log::debug("日付が異なります。DB上のフォロー数をリセットし、DB上の日付を変更します。");
            //フォロー数をリセットし、本日に日付に更新。
            Auth::user()->follow_count = 0;
            Auth::user()->follow_day = $today;
            Auth::user()->update();
            Session::forget('today_follow_end');//フォロー自体できなくなる処理をリセット
        } else {
            //db上のフォローをした日付と本日が同じ場合は特に何もしない
            Log::debug("以前の日付と同じです。DB上のフォロー数は維持されます。");
        }


        //1日のフォロー数制限が395超えていたらフォローできないようにするフラグをonにする
        Log::debug("一日のフォロー数制限が395超えていたらフォローできないように制限します。");
        $follow_count = Auth::user()->follow_count;
        Log::debug("本日このサービスでフォローした数" . $follow_count);
        if ($follow_count > 395) //本来は395にする！
        {
            Log::debug("すでに385フォロー超えています。");
            Session::put('today_follow_end', true);

        } else {
            Log::debug("まだフォロー数は395を超えていません。");
            Session::put('today_follow_end', false);
        }


        //アカウント一覧を表示させる処理：ツイッター認証していない場合
        //もしTwitter認証をしていない場合、ビュー側ではフォローできるアカウント情報は出さない。
        //代わりにajaxでdb上から取得したユーザーデータを表示させる。値は$temp_userに入れます。

        $follow_users = array();
        for ($i = 0; $i < 15; $i++) {
            //DBからユーザーを15人、screen_nameのみランダムに取得し、$randomUserに詰め込む。
            $randomUser = Autofollow::inRandomOrder()->first();
            //それを$follow_usersに詰め込む
            array_push($follow_users, $randomUser->screen_name);
        }
        //$follow_usersはランダムにDBから取得したユーザー情報。
        //ツイッター認証していない場合はそのユーザーをそのまま表示させる。
        //■■■アカウント一覧を表示させる処理：ツイッター認証している場合■■■
        //ツイッター認証している場合は、$follow_usersから取得した中で、ログインユーザーが
        //「まだフォローしてないユーザーの情報のみ」を取得し$lookupuserに格納。
        //「まだフォローしてないユーザーの情報のみ」を画面に表示させます。
        $follow_users = implode(",", $follow_users);//クォーテーションをつける。

        $user_id = Auth::id();
        $account_id = TwitterAccount::where('user_id',$user_id)->value('id');
        $api_key = 'n2BFchS09CY5Myr9ZxTvJX887';
        $api_secret = 'ShH0CWC93JF9uYjlyAlOt2vSgtUHG7j4NogjBTvxaYEVo6YGeP';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');
        $screen_name = $follow_users;

        $lookup = new LookupSearchService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name);
        $results = $lookup->lookup();

        $user_token = $access_token;
        if ($user_token) {
            Session::put('user_token',$user_token);
        } else {
            Session::forget('user_token');
        }

        $data = session()->all();

        Log::debug(print_r('$user_token',true));
        Log::debug(print_r($user_token,true));
        Log::debug(print_r($data,true));
        Log::debug(print_r($user_token,true));


        $getuser = count($results);
        Log::debug("取得できた数。");
        Log::debug($getuser);
        $temp_user = array();
        //取得データから「following」がfalse（フォローしてない）ユーザーであれば
        //$temp_userに格納（まとめてフォローは15分に1度実施可能にし、14人まで。）
        for ($i = 0; $i < $getuser; $i++) {
            if (!isset($results[$i]->following) || !$results[$i]->following) {
                $temp_user[] = ($results[$i]);
            }
        }
//    $temp_userをjsonエンコードし、$users_resultsユーザー情報を取得する。
        $users_results = json_encode($temp_user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return view('twitter.autofollow', compact('users_results', 'follow_users', 'autofollow_check'));
        //viewに渡す変数の説明↓
        //$follow_usersはランダムにDBから取得したユーザー情報。
        //$users_resultsは、ログインユーザーがフォローしてないユーザー一覧のスクリーンネーム。
        //autofollow_checkは、dbからログインしているユーザーの自動フォローの状態を判断したフラグ。0ならオートフォローは実施していない、1なら実施している

    }


    //ーーーーーーーーーー自動フォローのON/OFF切り替えーーーーーーーーーー

    public function all(Request $request)
    {
        Log::debug("自動フォローのonoffを↓に切り替えます。");
        //$status = $request->auto_status;
        Log::debug($request['request']);//1
        //Log::debug($request);
        $user = Auth::user();
        //Log::debug($user);//1
        $user->autofollow = $request['request'];//数字を更新。
        $user->update();
        return;
    }


    //ーーーーーユーザーを1日に数人DB追加するメソッド。cronで数回実施。依存ユーザーの情報がある場合はツイート更新。
    public static function addfollow()
    {
        $account_id = TwitterAccount::where('id')->value('twitter_id');
        $api_key = 'n2BFchS09CY5Myr9ZxTvJX887';
        $api_secret = 'ShH0CWC93JF9uYjlyAlOt2vSgtUHG7j4NogjBTvxaYEVo6YGeP';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');
        $q = '仮想通貨';
        $count = 20;
        $page = mt_rand(1, 10);

        $search = new TwitterUserSearchService($api_key, $api_secret, $access_token, $access_token_secret, $q, $count, $page);
        $arr = $search->search();

        $users_results = [];

        for ($i = 0; $i < 19; $i++) {
            $users_results[$i]['screen_name'] = $arr[$i]['screen_name'];
            $users_results[$i]['twitter_id'] = $arr[$i]['id'];
            $users_results[$i]['registtime'] = date('Y-m-d H:i:s', strtotime($arr[$i]['created_at']));
            $users_results[$i]['screen_name'] = $arr[$i]['screen_name'];
            $users_results[$i]['user_id'] = $arr[$i]['id'];
            $users_results[$i]['name'] = $arr[$i]['name'];
            $users_results[$i]['profile_image'] = $arr[$i]['profile_image_url'];
            $users_results[$i]['friends_count'] = $arr[$i]['friends_count'];
            $users_results[$i]['followers_count'] = $arr[$i]['followers_count'];
            $users_results[$i]['description'] = $arr[$i]['description'];
            $users_results[$i]['text'] = $arr[$i]['status']['text'];
            $users_results[$i]['following'] = $arr[$i]['following'];

            Log::debug(print_r($users_results[$i]['text'], true));
        }

        //updateOrCreateを使い同じscreen_nameがDB上autofollowsテーブルにあるかどうか確認し（第一引数）、
        //第二引数で情報を挿入、または既存のユーザー情報があるなら更新。

        DB::beginTransaction();
        try {
            for ($i = 0; $i < 19; $i++) {
                $autofollow = Autofollow::updateOrCreate(
                    [//第一引数
                        'screen_name' => $users_results[$i]['screen_name']
                    ],
                    [//第二引数
                        'screen_name' => $users_results[$i]['screen_name'], 'twitter_id' => $users_results[$i]['twitter_id'],
                        'name' => $users_results[$i]['name'], 'text' => $users_results[$i]['text'],
                        'registtime' => $users_results[$i]['registtime'],
                    ]
                );
            }
            DB::commit(); // コミット
        } catch (\Exception $e) {
            DB::rollback(); // ロールバック
            return;
        }


        //DB上の更新日時記録テーブルを更新
        date_default_timezone_set('Asia/Tokyo');
        $now_time = date("Y-m-d H:i:s");//今の時間
        $addusertime_update = Updatetime::where('id', 1)->first();//dbからデータ取得
        $data = ['update_twitter' => $now_time];

        DB::beginTransaction();
        try {
            $addusertime_update->update($data);
            DB::commit(); // コミット
        } catch (\Exception $e) {
            DB::rollback(); // ロールバック
            return;
        }

        $results = json_encode($users_results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $results;
    }


    //ーーーーーーオートフォローアクション。cronで自動で行われる処理。15分に一度実施されます。
    //ーーーーーーDBからオートフォロー「1」にされていると実施される
    public static function autofollow()
    {
        Log::debug("オートフォロー開始します");

        //DBからユーザーを15人、screen_nameのみランダムに取得し、$randomUserに詰め込む。
        //そのscreen_nameを$follow_targetsに詰め込む
        $follow_targets = array();
        for ($i = 0; $i < 15; $i++) {
            $randomUser = Autofollow::inRandomOrder()->first();
            array_push($follow_targets, $randomUser->screen_name);
        }
        Log::debug(print_r('$follow_targetsの表示///////////////', true));
        Log::debug(print_r($follow_targets, true));


        //フォロー元のユーザーアカウント（db上のautofollowが1のユーザー）を検索。
        //また、そのユーザー数をカウントする。
        $follow_acount = User::where('autofollow', 1)->get();
        Log::debug("autoフォロー1の状態の人です。" . $follow_acount);
        $num = count($follow_acount);
        Log::debug("numです" . $num);
        if ($num === 0) {
            Log::debug("自動フォロー実行中の人がいません。終了します");
            return;
        }
        sleep(1);//負荷分散のため1秒間を開ける

        //-----------各々のユーザーで自動フォローを行う。
        //カウント数までforで回し、フォロー元ユーザーのツイッター情報認証を取得。
        //フォローしていない ＝ followingがfalseのユーザーのみtempに詰め込む
        //1週目$iは0 numは2。
        for ($i = 0; $i < $num; $i++) {

            Log::debug("iの中身です" . $i);
            //1日のフォロー数制限が385超えていたらフォローできないようにするフラグをonにする
            //Log::debug("処理2:一日のフォロー数制限が385超えていたらフォローできないように制限します。");

            //一人分の自動フォロー処理。------------------------------■
            $follow_count = $follow_acount[$i]->follow_count;
            $follow_id = $follow_acount[$i]->id;
            Log::debug("本日このサービスでフォローした数" . $follow_count);

            if ($follow_count > 395) {
                Log::debug("すでに1日のフォロー数が395を超えています。処理を終了します。");
            } else {
                Log::debug("まだフォロー数は395を超えていません。ここからフォロー処理を実施します。");

                $account_id = TwitterAccount::where('user_id', $follow_id)->value('twitter_id');
//                Log::debug(print_r('$account_idを表示します///////////////////',true));
//                Log::debug(print_r($account_id,true));
                $api_key = 'n2BFchS09CY5Myr9ZxTvJX887';
                $api_secret = 'ShH0CWC93JF9uYjlyAlOt2vSgtUHG7j4NogjBTvxaYEVo6YGeP';
                $access_token = TwitterAccount::where('twitter_id', $account_id)->value('oauth_token');
                $access_token_secret = TwitterAccount::where('twitter_id', $account_id)->value('oauth_token_secret');

                foreach ($follow_targets as $value) {
                    //Log::debug($value);
                    $screen_name = $value;
                    Log::debug("screen_nameの中身" . $screen_name);
                    $follow = new FollowingService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name);
                    $results = $follow->following();
                    Log::debug(print_r($results, true));
                }


                //フォローした数をカウントとしてdbに追加。
                $count = count($follow_targets);
                $now_follow_num = $follow_acount[$i]->follow_count;//処理中のユーザーのカウント数
                $now_follow_num = $now_follow_num + $count;

                Log::debug("フォローした人数です" . $count);
                Log::debug("db上の数です。" . $now_follow_num);
                Log::debug("dbにオールフォロー数を足しました、saveします！db上の数はこちらに更新されます→" . $now_follow_num);

                $user = User::where('id', $follow_id)->first();
                $user->follow_count = $now_follow_num;
                $user->update();

                Log::debug("DBを更新しました");

                Log::debug("フォロー処理を終了します。");

            }
            Log::debug($follow_acount[$i]->name . "さんの処理が終わりました。");
            sleep(5);
        }
        Log::debug("オートフォロー全て終了します");
    }


}
