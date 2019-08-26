<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_balance', function (Blueprint $table) {            //
            $table->increments('id');
            $table->integer('member_id')->unsigned()->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade')->comment('会员');
            $table->enum('mode', ['free', 'recharge', 'order', 'deduct'])->default('recharge')->comment('free，赠送；recharge，充值；order，消费；deduct， 扣除');
            $table->decimal('value', 12, 2)->default(0.00)->comment('变更值');
            $table->timestamp('created_at')->nullable()->comment('添加时间');
        });
        Schema::create('merchant_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('parent_role', ['company', 'shareholder', 'agent', 'proxy','member'])->default('member')->comment('上级角色：company，分公司；shareholder，股东；agent，总代理；proxy， 代理；member，会员');
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade')->comment('商户ID');
            $table->enum('child_role', ['company', 'shareholder', 'agent', 'proxy','member'])->default('member')->comment('关联角色：company，分公司；shareholder，股东；agent，总代理；proxy， 代理；member，会员');
            $table->integer('user_id')->unsigned()->nullable()->comment('关联用户ID');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_balance');
        Schema::dropIfExists('merchant_relations');
    }
}
