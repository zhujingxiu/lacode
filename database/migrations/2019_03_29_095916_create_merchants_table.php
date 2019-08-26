<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('system_roles')->onDelete('cascade')->comment('商户角色');
            $table->foreign('parent_id')->references('id')->on('merchants')->onDelete('cascade')->comment('上级商户');
            $table->string('code', 16)->unique()->default('')->comment('安全码');
            $table->string('name', 64)->unique()->comment('用户账户');
            $table->string('nick_name', 64)->default('')->comment('用户昵称');
            $table->tinyInteger('status')->default(1)->comment('状态：1,激活;0,停用;-1,冻结');
            $table->tinyInteger('online')->default(1)->comment('是否在线');
            $table->tinyInteger('reset')->default(1)->comment('重置密码');
            $table->string('login_token', 32)->default('')->comment('登录token，验证登录唯一');
            $table->string('last_ip', 128)->default('')->comment('最后IP');
            $table->timestamp('last_login')->nullable()->comment('最后登录时间');
            $table->integer('admin_id')->default(0)->comment('添加人');
            $table->string('password', 256)->default('');

            $table->timestamps();
        });

        Schema::create('merchant_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->comment('商户');
            $table->decimal('credit', 12, 2)->default(0.00)->comment('额度');
            $table->decimal('balance', 12, 2)->default(0.00)->comment('信用余额');
            $table->decimal('rate',6,2)->default(0.00)->comment('占成比例');
            $table->decimal('rate_limit',6,2)->default(0.00)->comment('占成限制');
            $table->boolean('rate_company')->default(TRUE)->comment('总公司占余成');
            $table->boolean('replenish')->default(FALSE)->comment('补货功能');
            $table->boolean('order_now')->default(FALSE)->comment('是否即时注单');
            $table->decimal('charges', 5, 2)->default(0.00)->comment('赚佣比例');
        });
        Schema::create("merchant_games", function(Blueprint $table){
            $table->increments('id');
            $table->integer('merchant_id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->comment('商户ID');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade')->comment('彩种ID');
            $table->boolean('status')->default(TRUE)->comment('状态');
            $table->boolean('transfer')->default(FALSE)->comment('转投');
            $table->string('transfer_url', 128)->default('')->comment('转投地址');
            $table->boolean('cheat')->default(FALSE)->comment('状态');
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
        Schema::dropIfExists('merchants');
        Schema::dropIfExists('merchant_infos');
        Schema::dropIfExists('merchant_games');
        Schema::enableForeignKeyConstraints();
    }
}
