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
//ターゲットアカウントリスト
Route::get('/twitter/targets', 'TargetsController@index')->name('twitter.targets');

Route::post('/twitter/targets/new', 'TargetsController@create')->name('twitter.targets.create');

Route::post('/twitter/targets/edit', 'TargetsController@edit')->name('twitter.targets.edit');

Route::post('/twitter/targets/delete', 'TargetsController@destroy')->name('twitter.targets.destroy');


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

/////////////////////////////////////
/// twitterapi
//フォロワーサーチ
Route::get('/twitter/api/search/follower', 'FollowedTargetsController@create')->name('twitter.search.follower');

//フォロー
Route::get('/twitter/api/follow', 'FollowingTargetsController@create')->name('twitter.follow');

//アンフォロー
Route::get('/twitter/api/unfollow', 'UnfollowersController@create')->name('twitter.unfollow');

