<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\AutofollowController;

//todo
class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testcommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'testcommandのコマンド説明';

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
    {
//        CoinController::highandlow();
//        CoinController::hour();
//        CoinController::day();
//        CoinController::week();
//        CoinController::index();
//        AutofollowController::addfollow();
//        AutofollowController::autofollow();

    }
}
