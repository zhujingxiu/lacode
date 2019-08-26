<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 64)->default('')->comment('标题');
            $table->text('content')->comment('内容');
            $table->boolean('member')->default(TRUE)->comment('会员页显示');
            $table->boolean('merchant')->default(FALSE)->comment('代理商户页显示');
            $table->boolean('modal')->default(FALSE)->comment('模态窗显示');
            $table->boolean('status')->default(TRUE)->comment('显示状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
