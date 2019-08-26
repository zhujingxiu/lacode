<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_history', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role', ['merchant','member'])->default('member')->comment('类型：商户，会员');
            $table->integer('user_id')->default(0)->comment('商户ID或会员ID');
            $table->string('action', 64)->default('')->comment('动作');
            $table->text('data')->nullable()->comment('修改前数据');
            $table->text('request')->nullable()->comment('修改的请求数据');
            $table->string('note', 256)->default('')->comment('备注');
            $table->string('ip',32)->default('')->comment('IP地址');
            $table->string('locate',128)->default('')->comment('地址详情');
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->comment('变更人');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_history');
    }
}
