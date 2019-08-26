<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantRebatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create("merchant_rebates", function(Blueprint $table){
            $table->increments('id');
            $table->enum('role', ['merchant','member'])->default('member')->comment('类型：商户，会员');
            $table->integer('user_id')->default(0)->comment('商户ID或会员ID');
            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('game_options')->onDelete('cascade')->comment('彩标ID');
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
        Schema::dropIfExists('merchant_rebates');
        Schema::enableForeignKeyConstraints();
    }
}
