<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FollowingService;
use App\TwitterAccount;


class FollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //ーーーーーーーーーーフォローアクションーーーーーーーーーー

    public function follow(Request $request)
    {

        header("Access-Control-Allow-Origin: *");  //CROS
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");
        $user_id = $request->data{"user_id"};//リクエストからidとスクリーンネームを変数に入れる
        $username = $request->data{"user_name"};

        $user_id = Auth::id();
        $account_id = TwitterAccount::where('user_id', $user_id)->value('twitter_id');
        $api_key = 'n2BFchS09CY5Myr9ZxTvJX887';
        $api_secret = 'ShH0CWC93JF9uYjlyAlOt2vSgtUHG7j4NogjBTvxaYEVo6YGeP';
        $access_token = TwitterAccount::where('twitter_id', $account_id)->value('oauth_token');
        $access_token_secret = TwitterAccount::where('twitter_id', $account_id)->value('oauth_token_secret');
        $screen_name = $username;

        $follow = new FollowingService($api_key, $api_secret, $access_token, $access_token_secret, $screen_name);
        $results = $follow->following();

        $now_follow_num = Auth::user()->follow_count;
        $sum = $now_follow_num + 1;
        Auth::user()->follow_count = $sum;
        Auth::user()->update();

        return response()->json(['result' => true]);
    }


}
