<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueIndexToGameLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_lotteries', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->unique(['game_id', 'issue']);
        });
        Schema::table('game_schedule_issues', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->unique(['game_id', 'issue']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_lotteries', function (Blueprint $table) {
            //
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['game_id']);
            $table->dropUnique(['game_id', 'issue']);
            Schema::enableForeignKeyConstraints();
        });
        Schema::table('game_schedule_issues', function (Blueprint $table) {
            //
            Schema::disableForeignKeyConstraints();
            $table->dropForeign(['game_id']);
            $table->dropUnique(['game_id', 'issue']);
            Schema::enableForeignKeyConstraints();
        });
    }
}
