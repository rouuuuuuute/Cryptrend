<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Updatetime;
use App\Coin;
use App\Services\CoinSearchService;

//通貨トレンド関連のクラス。
//indexでページを表示させ、hour/day/week/highandlowでdb上のcoinテーブルの値を更新。cronで定期更新
class CoinController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //ーーーーーーーーーーページの表示ーーーーーーーーーー
    public function index()
    {
        //Log::debug("ーーーーーーーーーーーーーーー仮想通貨トレンドのページですーーーーーーーーーーーーーーー");

        $coinupdatedate = Updatetime::where('id', 1)->first();//全てのコインの更新日時をDBより引用
        $hour = $coinupdatedate["update_hour"];//時間単位のツイートの更新日時
        $day = $coinupdatedate["update_day"];//1日単位のツイートの更新日時
        $week = $coinupdatedate["update_week"];
        $highlow = $coinupdatedate["update_highandlow"];

        return view('home.coin', compact('hour', 'day', 'week', 'highlow'));
//        return view('home.coin');
    }


    //ーーーーーーーーーーDBに1時間のツイート数をインサートする処理（定期バッジ）ーーーーーーーーーー
    public static function hour()
    {
        Log::debug(print_r('////////////////////////////////////////', true));
        Log::debug(print_r('Coinコントローラーの処理を開始します', true));

        $now_time = date("Y-m-d_H:i:s") . "_JST";//今の時間
        $before_time = date('Y-m-d_H:i:s', strtotime('-1 hour', time())) . "_JST";
        $past = 'hour';
        $request_loop = 1;

        $coin = new CoinSearchService($now_time, $before_time, $past, $request_loop);
        $coin->coinsearch();

        date_default_timezone_set('Asia/Tokyo');
        $now_time = date("Y-m-d H:i:s");//今の時間
        $addusertime_update = Updatetime::where('id', 1)->first();//dbからデータ取得
        $data = ['update_hour' => $now_time];
        $addusertime_update->update($data);

        return;
    }

    //ーーーーーーーーーーDBに1日のツイート数をインサートする処理（定期バッジ）ーーーーーーーーーー
    public static function day()
    {

        Log::debug(print_r('////////////////////////////////////////', true));
        Log::debug(print_r('Coinコントローラーの処理を開始します', true));

        $now_time = date("Y-m-d_H:i:s") . "_JST";//今の時間
        $before_time = date('Y-m-d_H:i:s', strtotime('-1 day', time())) . "_JST";
        $past = 'day';
        $request_loop = 24;

        $coin = new CoinSearchService($now_time, $before_time, $past, $request_loop);
        $coin->coinsearch();

        date_default_timezone_set('Asia/Tokyo');
        $now_time = date("Y-m-d H:i:s");//今の時間
        $addusertime_update = Updatetime::where('id', 1)->first();//dbからデータ取得
        $data = ['update_day' => $now_time];
        $addusertime_update->update($data);

        return;
    }

    public static function week()
    {

        Log::debug(print_r('////////////////////////////////////////', true));
        Log::debug(print_r('Coinコントローラーの処理を開始します', true));

        $now_time = date("Y-m-d_H:i:s") . "_JST";//今の時間
        $before_time = date('Y-m-d_H:i:s', strtotime('-7 day', time())) . "_JST";
        $past = 'week';
        $request_loop = 100;

        $coin = new CoinSearchService($now_time, $before_time, $past, $request_loop);
        $coin->coinsearch();

        date_default_timezone_set('Asia/Tokyo');
        $now_time = date("Y-m-d H:i:s");//今の時間
        $addusertime_update = Updatetime::where('id', 1)->first();//dbからデータ取得
        $data = ['update_week' => $now_time];
        $addusertime_update->update($data);

        return;
    }

    //ーーーーーーーーーーcoincheckAPIから取引価格取得しDBに保管（定期バッジ）ーーーーーーーーーー
    public static function highandlow()
    {

        $API_btc_URL = "https://coincheck.com/api/ticker";
        $btc_json = file_get_contents($API_btc_URL);
        $btc_json = mb_convert_encoding($btc_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $btc = json_decode($btc_json, true);

        $API_etc_URL = "https://coincheck.com/api/ticker?pair=etc_jpy";
        $etc_json = file_get_contents($API_etc_URL);
        $etc_json = mb_convert_encoding($etc_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $etc = json_decode($etc_json, true);

        $API_plt_URL = "https://coincheck.com/api/ticker?pair=plt_jpy";
        $plt_json = file_get_contents($API_plt_URL);
        $plt_json = mb_convert_encoding($plt_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $plt = json_decode($plt_json, true);

        $API_mona_URL = "https://coincheck.com/api/ticker?pair=mona_jpy";
        $mona_json = file_get_contents($API_mona_URL);
        $mona_json = mb_convert_encoding($mona_json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $mona = json_decode($mona_json, true);


        $coin_btc = Coin::where('id', 1)->first();
        $coin_etc = Coin::where('id', 3)->first();
        $coin_plt = Coin::where('id', 16)->first();
        $coin_mona = Coin::where('id', 9)->first();


        $coin_btc->high = $btc['high'];
        $coin_btc->low = $btc['low'];
        $coin_btc->save();

        $coin_etc->high = $etc['high'];
        $coin_etc->low = $etc['low'];
        $coin_etc->save();

        $coin_plt->high = $plt['high'];
        $coin_plt->low = $plt['low'];
        $coin_plt->save();

        $coin_mona->high = $mona['high'];
        $coin_mona->low = $mona['low'];
        $coin_mona->save();


        //DB上の更新日時記録テーブルを更新
        date_default_timezone_set('Asia/Tokyo');
        $now_time = date("Y-m-d H:i:s");//今の時間
        //Log::debug($now_time);
        $addusertime_update = Updatetime::where('id', 1)->first();//dbからデータ取得
        $data = ['update_highandlow' => $now_time];
        $addusertime_update->update($data);
        return;
    }


}
