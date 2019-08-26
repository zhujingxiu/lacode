<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role',['merchant','admin'])->default('merchant')->comment('商户后台或管理后台');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade')->comment('父菜单');
            $table->string('title',32)->default('')->comment('标题');
            $table->string('path', 128)->default('')->comment('URL');
            $table->string('style',32)->default('')->comment('样式');
            $table->string('icon',32)->default('')->comment('ICON');
            $table->smallInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('menus');
    }
}
