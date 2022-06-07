<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatetimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updatetimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('update_hour')->nullable();
            $table->timestamp('update_day')->nullable();
            $table->timestamp('update_week')->nullable();
            $table->timestamp('update_highandlow')->nullable();
            $table->timestamp('update_twitter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('updatetimes');
    }
}
