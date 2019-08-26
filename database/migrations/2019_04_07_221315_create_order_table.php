<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('oid', 32)->unique()->default('')->comment('UUID');
            $table->integer('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade')->comment('会员');
            $table->integer('game_id')->unsigned()->nullable();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('会员');
            $table->integer('odds_id')->unsigned()->nullable();
            $table->foreign('odds_id')->references('id')->on('game_odds')->onDelete('cascade')->comment('赔率项ID');
            $table->string('issue',32)->comment('期号');
            $table->decimal('amount',12,2)->default(0.00)->comment('下注金额');
            $table->decimal('profit',12,2)->default(0.00)->comment('收益金额');
            $table->boolean('status')->default(0)->comment('结算状态,0是未结算,1是已结算');
            $table->string('sign',32)->comment('加密项');
            $table->string('note',128)->comment('备注项');
            $table->timestamps();
        });
        Schema::create('order_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->comment('订单编号');
            $table->string('g_key',32)->comment('扩展键名');
            $table->string('g_value',32)->comment('键值');
        });

        Schema::create('order_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->comment('订单编号');
            $table->tinyInteger('status_id')->default(0)->comment('状态值');
            $table->enum('role',['member','merchant','api','admin'])->default('member')->comment('键值');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('note',64)->comment('备注项');
            $table->timestamp('created_at')->nullable()->comment('添加时间');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_infos');
        Schema::dropIfExists('order_logs');
        Schema::enableForeignKeyConstraints();
    }
}
