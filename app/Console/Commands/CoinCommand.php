<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\CoinController;


class CoinCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:coincommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coinの DB上取引額データを更新します';

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
      CoinController::highandlow();
    }
}
