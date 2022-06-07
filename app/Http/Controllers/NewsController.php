<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        set_time_limit(90);
        $max_num = 50;
        $keyword = "仮想通貨";//検索キーワード
        $query = urlencode(mb_convert_encoding($keyword,"UTF-8", "auto"));
        $API_BASE_URL = "https://news.google.com/rss/search?ie=UTF-8&oe=UTF-8&q=".$query."&hl=ja&gl=JP&ceid=JP:ja";
        $items = simplexml_load_file($API_BASE_URL)->channel->item;

        //記事のタイトルとURLを取り出して配列に格納
        //mb_convert_encodingで文字列を変換
        for ($i = 0; $i < count($items); $i++) {
            $list[$i]['title'] = mb_convert_encoding($items[$i]->title,"UTF-8", "auto");
            $list[$i]['url'] = mb_convert_encoding($items[$i]->link,"UTF-8", "auto");
            $list[$i]['pubDate'] = mb_convert_encoding($items[$i]->pubDate,"UTF-8", "auto");
            $list[$i]['description'] = mb_convert_encoding($items[$i]->description,"UTF-8", "auto");
        }

        //$max_num以上の記事数の場合は切り捨て
        if(count($list)>$max_num){
            for ($i = 0; $i < $max_num; $i++){
                $list_gn[$i] = $list[$i];
                $i++;
            }
        }else{
            $list_gn = $list;
        }
        return view('news.news',compact('list_gn'));
    }

}
