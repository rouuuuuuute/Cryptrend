<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/welcome', function () {
    return view('welcome');
});


//Twitterアカウント
// cryptrendで使ってる
Route::get('/twitter/accounts', 'TwitterAccountsController@index')->name('twitter.accounts');

Route::POST('/twitter/accounts/request', 'TwitterAccountsController@request')->name('twitter.accounts.request');

Route::POST('/twitter/accounts/delete', 'TwitterAccountsController@destroy')->name('twitter.accounts.destroy');

/////////////////////////////////////
/// // cryptrendで使ってる
//プロフィール画面
Route::get('/profile', 'ProfileController@index')->name('home.profile');

Route::post('/profile/edit', 'ProfileController@edit')->name('home.profile.edit');

Route::post('/profile/withdraw', 'ProfileController@withdraw')->name('home.profile.withdraw');

/////////////////////////////////////
// cryptrendで使ってる
//Googleニュース
Route::get('/news', 'NewsController@index')->name('news.index');

/////////////////////////////////////
// cryptrendで使ってる
//coin
Route::get('/home', 'CoinController@index')->name('home.index');
Route::get('coin/hour','CoinController@hour')->name('coin.hour');//1日のツイート数を検索。cronで実施。
Route::get('coin/day','CoinController@day')->name('coin.day');//1日のツイート数を検索。cronで実施。
Route::get('coin/week','CoinController@week')->name('coin.week');//1日のツイート数を検索。cronで実施。
Route::get('coin/highandlow','CoinController@highandlow')->name('coin.highandlow');//1日のツイート数を検索。cronで実施。



/////////////////////////////////////
//cryptrendで使ってる
//オートフォローコントローラー（フォローを実施できるページ）
Route::get('/twitter/autofollow','AutofollowController@index')->name('autofollow.index');
Route::post('/twitter/autofollow/all','AutofollowController@all')->name('autofollow.all');//自動フォローをonにする処理
Route::get('/twitter/autofollow/addfollow','AutofollowController@addfollow')->name('autofollow.addfollow');//DBにツイッターアカウントを追加。cronに追加する処理
Route::get('/twitterautofollow/autofollow','AutofollowController@autofollow')->name('autofollow.autofollow');//自動フォロー。15分に一度行う。
Route::get('/twitterautofollow/sampleindex','AutofollowController@sampleindex')->name('autofollow.autofollow');//サンプル表示

Route::post('/twitter/autofollow/follow','FollowController@follow')->name('autofollow.follow');//フォロー

/////////////////////////////////////
//ajax
Route::get('/twitter/json/accounts', 'RequestDatabaseController@accounts');
Route::get('/twitter/keywords/follow/json/keywords', 'RequestDatabaseController@keywords');
Route::get('/twitter/keywords/favorites/json/keywords', 'RequestDatabaseController@favoriteKeywords');
Route::get('/twitter/tweets/json/tweets', 'RequestDatabaseController@tweets');
Route::get('/twitter/tweets/json/reserved', 'RequestDatabaseController@time');
Route::get('/home/json/name', 'RequestDatabaseController@name');
Route::get('/home/json/email', 'RequestDatabaseController@email');
Route::get('/twitter/targets/json/targets', 'RequestDatabaseController@targets');

Route::get('/twitter/follower/json/ratelimit', 'RequestDatabaseController@ratelimit');

//ajaxのデータを表示させるvue
Route::get('ajax/coin', 'AjaxController@coin')->name('ajax.coin');
