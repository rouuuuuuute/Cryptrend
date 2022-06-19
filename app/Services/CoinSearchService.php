<?php

namespace App\Services;

//通貨トレンド関連のクラス。
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\TwitterAccount;
use App\Services\SearchService;
use App\Coin;


class CoinSearchService
{

    //プロパティ
    public $now_time;
    public $before_time;

    public function __construct($now_time, $before_time, $past, $request_loop)
    {
        $this->now_time = $now_time;
        $this->before_time = $before_time;
        $this->past = $past;
        $this->request_loop = $request_loop;

    }

    public function coinsearch()
    {
        Log::debug(print_r('////////////////////////////////////////', true));
        Log::debug(print_r('CoinSearchSrviceの処理を開始します', true));

        //ツイッター認証
        $account_id = TwitterAccount::where('id')->value('twitter_id');
        $api_key = 'n2BFchS09CY5Myr9ZxTvJX887';
        $api_secret = 'ShH0CWC93JF9uYjlyAlOt2vSgtUHG7j4NogjBTvxaYEVo6YGeP';
        $access_token = TwitterAccount::where('id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('id', $account_id)->value('oauth_token_secret');

        Log::debug(print_r($account_id, true));
        Log::debug(print_r($access_token, true));
        Log::debug(print_r($access_token_secret, true));

        date_default_timezone_set('Asia/Tokyo');//https://blog.codecamp.jp/php-datetime参考
        $now_time = $this->now_time;
        $before_time = $this->before_time;
        $past = $this->past;
        $request_loop = $this->request_loop;
        $tweet_results = array();

        $q = "'BTC' OR 'ETH' OR 'ETC' OR 'LSK' OR 'FCT' OR 'XRP' OR 'XEM' OR 'LTC' OR 'BCH' OR 'MONA' OR 'DASH' OR 'ZEC' OR 'XMR' OR 'REP' OR 'XLM' OR 'QTUM' OR 'BAT' OR 'IOST' OR 'ENJ' OR 'OMG' OR 'PLT' OR 'SAND' OR 'XYM' OR 'FCT'";

        Log::debug(print_r('SearchServiceの処理を開始します', true));

        //アクセストークン取得用のサービスクラスをよびだす
        $search = new SearchService($api_key, $api_secret, $access_token, $access_token_secret, $q, $before_time, $now_time);
        $results = $search->search();

        Log::debug(print_r('SearchServiceの処理を終了', true));
        Log::debug(print_r($results, true));

        $c = 0;
        for ($i = 0; $i < $request_loop; $i++) {
            foreach ($results['statuses'] as $val) {
                $tweet_results[$c]['text'] = $val['text']; //取得したツイートを配列へ積み重ねていく
                $c++;
            }

            //これ以上取得できるツイートがあるか条件分岐
            if (isset($results['search_metadata']['next_results'])) {
                //次ページのmax_id値を取得
                $max_id = preg_replace('/.*?max_id=([\d]+)&.*/', '$1', $results['search_metadata']['next_results']);
                $options['max_id'] = $max_id; // あればmax_idをoptionsに追加
            } else {
                break; // なければループを抜ける
            }
        }

        $btc = 0;
        $eth = 0;
        $etc = 0;
        $lsk = 0;
        $xrp = 0;
        $xem = 0;
        $ltc = 0;
        $bch = 0;
        $mona = 0;
        $xlm = 0;
        $qtum = 0;
        $bat = 0;
        $iost = 0;
        $enj = 0;
        $omg = 0;
        $plt = 0;
        $sand = 0;
        $xym = 0;
        $dash = 0;
        $zec = 0;
        $xmr = 0;
        $rep = 0;
        $fct = 0;

        $count = count($tweet_results);//ツイート数
        Log::debug(print_r('--------------------------------------------',true));
        Log::debug(print_r($count,true));

        //一致するテキストがあればカウントアップ
        for ($i = 0; $i < $count; $i++) {
            if (stristr($tweet_results[$i]['text'], 'BTC') !== false) {
                $btc++;
                Log::debug(print_r($tweet_results[$i]['text'],true));
                Log::debug(print_r($btc,true));
            }
            if (stristr($tweet_results[$i]['text'], 'ETH') !== false) {
                $eth++;
            }
            if (stristr($tweet_results[$i]['text'], 'ETC') !== false) {
                $etc++;
            }
            if (stristr($tweet_results[$i]['text'], 'LSK') !== false) {
                $lsk++;
            }
            if (stristr($tweet_results[$i]['text'], 'XRP') !== false) {
                $xrp++;
            }
            if (stristr($tweet_results[$i]['text'], 'XEM') !== false) {
                $xem++;
            }
            if (stristr($tweet_results[$i]['text'], 'LTC') !== false) {
                $ltc++;
            }
            if (stristr($tweet_results[$i]['text'], 'BCH') !== false) {
                $bch++;
            }
            if (stristr($tweet_results[$i]['text'], 'MONA') !== false) {
                $mona++;
            }
            if (stristr($tweet_results[$i]['text'], 'XLM') !== false) {
                $xlm++;
            }
            if (stristr($tweet_results[$i]['text'], 'QTUM') !== false) {
                $qtum++;
            }
            if (stristr($tweet_results[$i]['text'], 'BAT') !== false) {
                $bat++;
            }
            if (stristr($tweet_results[$i]['text'], 'IOST') !== false) {
                $iost++;
            }
            if (stristr($tweet_results[$i]['text'], 'ENJ') !== false) {
                $enj++;
            }
            if (stristr($tweet_results[$i]['text'], 'OMG') !== false) {
                $omg++;
            }
            if (stristr($tweet_results[$i]['text'], 'PLT') !== false) {
                $plt++;
            }
            if (stristr($tweet_results[$i]['text'], 'SAND') !== false) {
                $sand++;
            }
            if (stristr($tweet_results[$i]['text'], 'XYM') !== false) {
                $xym++;
            }
            if (stristr($tweet_results[$i]['text'], 'DASH') !== false) {
                $dash++;
            }
            if (stristr($tweet_results[$i]['text'], 'ZEC') !== false) {
                $zec++;
            }
            if (stristr($tweet_results[$i]['text'], 'XMR') !== false) {
                $xmr++;
            }
            if (stristr($tweet_results[$i]['text'], 'REP') !== false) {
                $rep++;
            }
            if (stristr($tweet_results[$i]['text'], 'FCT') !== false) {
                $fct++;
            }
        }

        $coin_btc = Coin::where('id', 1)->first();
        $coin_eth = Coin::where('id', 2)->first();
        $coin_etc = Coin::where('id', 3)->first();
        $coin_lsk = Coin::where('id', 4)->first();
        $coin_xrp = Coin::where('id', 5)->first();
        $coin_xem = Coin::where('id', 6)->first();
        $coin_ltc = Coin::where('id', 7)->first();
        $coin_bch = Coin::where('id', 8)->first();
        $coin_mona = Coin::where('id', 9)->first();
        $coin_xlm = Coin::where('id', 10)->first();
        $coin_qtum = Coin::where('id', 11)->first();
        $coin_bat = Coin::where('id', 12)->first();
        $coin_iost = Coin::where('id', 13)->first();
        $coin_enj = Coin::where('id', 14)->first();
        $coin_omg = Coin::where('id', 15)->first();
        $coin_plt = Coin::where('id', 16)->first();
        $coin_sand = Coin::where('id', 17)->first();
        $coin_xym = Coin::where('id', 18)->first();
        $coin_dash = Coin::where('id', 19)->first();
        $coin_zec = Coin::where('id', 20)->first();
        $coin_xmr = Coin::where('id', 21)->first();
        $coin_rep = Coin::where('id', 22)->first();
        $coin_fct = Coin::where('id', 23)->first();


        DB::beginTransaction();
        try {
            $coin_btc->$past = $btc;
            $coin_btc->save();

            $coin_eth->$past = $eth;
            $coin_eth->save();

            $coin_etc->$past = $etc;
            $coin_etc->save();

            $coin_lsk->$past = $lsk;
            $coin_lsk->save();

            $coin_xrp->$past = $xrp;
            $coin_xrp->save();

            $coin_xem->$past = $xem;
            $coin_xem->save();

            $coin_ltc->$past = $ltc;
            $coin_ltc->save();

            $coin_bch->$past = $bch;
            $coin_bch->save();

            $coin_mona->$past = $mona;
            $coin_mona->save();

            $coin_xlm->$past = $xlm;
            $coin_xlm->save();

            $coin_qtum->$past = $qtum;
            $coin_qtum->save();

            $coin_bat->$past = $bat;
            $coin_bat->save();

            $coin_iost->$past = $iost;
            $coin_iost->save();

            $coin_enj->$past = $enj;
            $coin_enj->save();

            $coin_omg->$past = $omg;
            $coin_omg->save();

            $coin_plt->$past = $plt;
            $coin_plt->save();

            $coin_sand->$past = $sand;
            $coin_sand->save();

            $coin_xym->$past = $xym;
            $coin_xym->save();

            $coin_dash->$past = $dash;
            $coin_dash->save();


            $coin_zec->$past = $zec;
            $coin_zec->save();

            $coin_xmr->$past = $xmr;
            $coin_xmr->save();

            $coin_rep->$past = $rep;
            $coin_rep->save();


            $coin_fct->$past = $fct;
            $coin_fct->save();

            DB::commit(); // コミット
        } catch (\Exception $e) {
            DB::rollback(); // ロールバック
            return;
        }

        return;
    }


}
