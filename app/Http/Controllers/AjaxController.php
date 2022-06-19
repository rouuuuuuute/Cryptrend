<?php

namespace App\Http\Controllers;

use App\Coin;

class AjaxController extends Controller
{
    //ーーーーーーーーーーajaxデータ。DBから取得したcoinデータをajaxとして出力ーーーーーーーーーー
    public function coin()
    {
        //コインデータ一覧をDBから表示
        return Coin::all();
    }

}
