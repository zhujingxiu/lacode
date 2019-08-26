<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 32)->default('')->comment('游戏标题');
            $table->string('code', 32)->unique()->default('')->comment('游戏标识');
            $table->string('token', 64)->default('')->comment('使用令牌');
            $table->string('table_lottery',64)->default('game_lotteries')->comment('开奖记录表');
            $table->smallInteger('total')->default(1)->comment('每天总期数');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('no_count')->default(1)->comment('号码个数');
            $table->string('no_style',32)->default('')->comment('号码附加样式');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->timestamps();
        });

        Schema::create('game_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->string('title', 32)->default('')->comment('标题');
            $table->string('code', 64)->nullable()->comment('标识');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->decimal('diff_b',6,3)->default(0.000)->comment('B盘赔率差值');
            $table->decimal('diff_c',6,3)->default(0.000)->comment('C盘赔率差值');
            $table->enum('trait',['special','serial','double','other'])->default('special')->comment('彩标类型：特码，连码，双面，其他');
        });

        Schema::create('game_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->string('title',32)->default('')->comment('分组名');
            $table->string('code', 64)->nullable()->comment('标识');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->boolean('status')->default(TRUE)->comment('状态');
        });

        Schema::create('game_bets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->string('title',32)->default('')->comment('分组名');
            $table->string('code', 64)->default('')->comment('标识');
            $table->string('style', 64)->default('')->nullable()->comment('样式');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->boolean('status')->default(TRUE)->comment('状态');
        });
        Schema::create('game_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->time('start_time')->nullable()->comment('首期起投时间');
            $table->smallInteger('total')->default(1)->comment('总期数');
            $table->smallInteger('interval')->default(60)->comment('每期间隔秒数');
            $table->smallInteger('ahead')->default(10)->comment('距开奖提前封盘的秒数');
            $table->smallInteger('sort')->default(1)->comment('排序');
            $table->boolean('status')->default(TRUE)->comment('状态');
        });
        Schema::create('game_schedule_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->date('release')->nullable()->comment('发行日期');
            $table->string('issue',16)->default('')->comment('期号');
            $table->dateTime('start_time')->nullable()->comment('本期起投时间');
            $table->dateTime('end_time')->nullable()->comment('本期分盘时间');
            $table->dateTime('open_time')->nullable()->comment('本期开奖时间');
            $table->boolean('status')->default(FALSE)->comment('状态，开盘期间为TRUE');
        });

        Schema::create('game_group_option', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('game_groups')->onDelete('cascade')->comment('彩种组别ID');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('game_options')->onDelete('cascade')->comment('彩种选项ID');
            $table->boolean('show')->default(TRUE)->comment('显示标题');
            $table->string('remark',32)->nullable()->comment('备注说明');
            $table->enum('repeat',['vertical','horizontal'])->default('horizontal')->comment('重复方式：垂直或水平');
            $table->tinyInteger('max')->default(1)->comment('最大个数');
            $table->string('style', 64)->default('')->nullable()->comment('样式');
            $table->smallInteger('sort')->default(1)->comment('排序');
        });

        Schema::create('game_odds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('game_groups')->onDelete('cascade')->comment('彩盘ID');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('game_options')->onDelete('cascade')->comment('彩标ID');
            $table->integer('bet_id')->unsigned();
            $table->foreign('bet_id')->references('id')->on('game_bets')->onDelete('cascade')->comment('彩注ID');
            $table->enum('roulette',['a','b','c','d'])->default('a')->comment('用户盘，d表默认');
            $table->decimal('g_value', 10, 3)->default(0.00)->comment('键值');
            $table->smallInteger('sort')->default(1)->comment('排序');
        });
        Schema::create("game_rebates", function(Blueprint $table){
            $table->increments('id');
            $table->enum('trait',['special','serial','double','other'])->default('special')->comment('彩标类型：特码，连码，双面，其他');
            $table->integer('game_id')->unsigned();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->string('g_key',32)->default('')->comment('键名');
            $table->decimal('g_value',12,2)->default(0.00)->comment('键值');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_options');
        Schema::dropIfExists('game_groups');
        Schema::dropIfExists('game_bets');
        Schema::dropIfExists('game_schedules');
        Schema::dropIfExists('game_schedule_issues');
        Schema::dropIfExists('game_group_option');
        Schema::dropIfExists('game_odds');
        Schema::dropIfExists('game_rebates');
        Schema::enableForeignKeyConstraints();
    }
}
