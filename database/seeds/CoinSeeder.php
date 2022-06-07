<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coins')->insert([
            'id' => 1,
            'coins_name' => 'btc'
        ]);
        DB::table('coins')->insert([
            'id' => 2,
            'coins_name' => 'eth'
        ]);
        DB::table('coins')->insert([
            'id' => 3,
            'coins_name' => 'etc'
        ]);
        DB::table('coins')->insert([
            'id' => 4,
            'coins_name' => 'lsk'
        ]);
        DB::table('coins')->insert([
            'id' => 5,
            'coins_name' => 'xrp'
        ]);
        DB::table('coins')->insert([
            'id' => 6,
            'coins_name' => 'xem'
        ]);
        DB::table('coins')->insert([
            'id' => 7,
            'coins_name' => 'ltc'
        ]);
        DB::table('coins')->insert([
            'id' => 8,
            'coins_name' => 'bch'
        ]);
        DB::table('coins')->insert([
            'id' => 9,
            'coins_name' => 'mona'
        ]);
        DB::table('coins')->insert([
            'id' => 10,
            'coins_name' => 'xlm'
        ]);
        DB::table('coins')->insert([
            'id' => 11,
            'coins_name' => 'qtum'
        ]);
        DB::table('coins')->insert([
            'id' => 12,
            'coins_name' => 'bat'
        ]);
        DB::table('coins')->insert([
            'id' => 13,
            'coins_name' => 'iost'
        ]);
        DB::table('coins')->insert([
            'id' => 14,
            'coins_name' => 'enj'
        ]);
        DB::table('coins')->insert([
            'id' => 15,
            'coins_name' => 'omg'
        ]);
        DB::table('coins')->insert([
            'id' => 16,
            'coins_name' => 'plt'
        ]);
        DB::table('coins')->insert([
            'id' => 17,
            'coins_name' => 'sand'
        ]);
        DB::table('coins')->insert([
            'id' => 18,
            'coins_name' => 'xym'
        ]);
        DB::table('coins')->insert([
            'id' => 19,
            'coins_name' => 'dash'
        ]);
        DB::table('coins')->insert([
            'id' => 20,
            'coins_name' => 'zec'
        ]);
        DB::table('coins')->insert([
            'id' => 21,
            'coins_name' => 'xmr'
        ]);
        DB::table('coins')->insert([
            'id' => 22,
            'coins_name' => 'rep'
        ]);
        DB::table('coins')->insert([
            'id' => 23,
            'coins_name' => 'fct'
        ]);


    }
}
