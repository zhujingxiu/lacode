<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role', ['merchant','member'])->default('member')->comment('类型：商户，会员');
            $table->integer('user_id')->default(0)->comment('商户ID或会员ID');
            $table->string('path', 64)->default('')->comment('路径');
            $table->string('note', 64)->default('')->comment('说明');
            $table->string('ip',32)->default('')->comment('IP地址');
            $table->string('locate',128)->default('')->comment('地址详情');
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
        Schema::dropIfExists('merchant_logs');
    }
}
