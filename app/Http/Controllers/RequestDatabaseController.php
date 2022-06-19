<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestDatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function accounts()
    {
        $user_id = Auth::id();
        return DB::table('twitter_accounts')->where('user_id', '=', $user_id)->get()->toJson();
    }

    public function name()
    {
        $id = Auth::id();
        return DB::table('users')->where('id', '=', $id)->value('name');
    }

    public function email()
    {
        $id = Auth::id();
        return DB::table('users')->where('id', '=', $id)->value('email');
    }


}
