<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameLotteryInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_lottery_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->string('issue',32)->default('')->comment('期号');
            $table->string('g_key',32)->default('')->comment('键名');
            $table->string('g_value',128)->default('')->comment('键值');

            $table->unique(['game_id', 'issue','g_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_lottery_infos');
    }
}
