<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CoinController;

//todo
class CoinhourCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:coinhourcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coin上の1時間のツイート数を更新';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {//実行するタスク
        CoinController::hour();
    }
}
