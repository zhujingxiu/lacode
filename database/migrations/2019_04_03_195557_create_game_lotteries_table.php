<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_lotteries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->string('issue',32)->default('')->comment('期号');
            $table->timestamp('open_time')->nullable()->comment('本期开奖时间');
            $table->tinyInteger('no_1')->default(-1)->comment('1号位或冠军');
            $table->tinyInteger('no_2')->default(-1)->comment('2号位或亚军');
            $table->tinyInteger('no_3')->default(-1)->comment('3号位');
            $table->tinyInteger('no_4')->default(-1)->comment('4号位');
            $table->tinyInteger('no_5')->default(-1)->comment('5号位');
            $table->tinyInteger('no_6')->default(-1)->comment('6号位');
            $table->tinyInteger('no_7')->default(-1)->comment('7号位');
            $table->tinyInteger('no_8')->default(-1)->comment('8号位');
            $table->tinyInteger('no_9')->default(-1)->comment('9号位');
            $table->tinyInteger('no_10')->default(-1)->comment('10号位');
            $table->tinyInteger('sum')->default(0)->comment('和值');
            $table->string('summery')->default('')->comment('开奖说明');
            $table->boolean('status')->default(TRUE)->comment('状态');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_lotteries');
    }
}
