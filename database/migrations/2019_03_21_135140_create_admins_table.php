<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->default(0)->comment('添加人');
            $table->string('name', 64)->unique()->comment('用户账户');
            $table->string('nick_name', 64)->default('')->comment('用户昵称');
            $table->tinyInteger('status')->default(1)->comment('状态：1,激活;0,停用;-1,冻结');
            $table->boolean('reset')->default(TRUE)->comment('重置密码');
            $table->boolean('online')->default(TRUE)->comment('在线');
            $table->string('login_token', 32)->default('')->comment('登录token，验证登录唯一');
            $table->string('last_ip', 128)->default('')->comment('最后IP');
            $table->timestamp('last_login')->nullable()->comment('最后登录时间');
            $table->string('password', 256)->default('');
            $table->timestamps();
        });

        Schema::create('system_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role',['admin','merchant'])->default('admin')->comment('账户类型：管理员，商户');
            $table->integer('parent')->default(0);
            $table->string('method')->default('GET')->comment('请求方法');
            $table->string('action', 64)->default('')->comment('访问方法');
            $table->string('title', 128)->default('');
            $table->string('path', 128)->default('')->comment('路径');
            $table->integer('menu_id')->default(0)->commet('菜单ID');
            $table->tinyInteger('auth')->default(1)->comment('验证');
            $table->tinyInteger('log')->default(0)->comment('记录');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1);
            $table->string('note', 128)->default('');
        });
        Schema::create('system_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role',['admin','merchant'])->default('admin')->comment('账户类型：管理员，商户');
            $table->string('title', 32)->default('');
            $table->string('code', 128)->default('')->comment('标志符');
            $table->tinyInteger('is_system')->default(1)->comment('系统角色');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create("system_role_permission", function(Blueprint $table){
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('system_roles')->onDelete('cascade')->comment('管理角色ID');
            $table->foreign('permission_id')->references('id')->on('system_permissions')->onDelete('cascade')->comment('权限节点ID');
        });
        //管理员的多对多角色关联
        Schema::create("admin_role_admin", function(Blueprint $table){
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('system_roles')->onDelete('cascade')->comment('管理角色ID');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->comment('管理员ID');
        });
        Schema::create('system_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('g_key', 64)->unique();
            $table->text('g_value');
            $table->enum('g_mode',['string','json','serializable'])->default('string');

        });
        Schema::create('login_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0);
            $table->enum('role',['admin','merchant','member','other'])->default('member')->comment('账户类型：管理员，商户，会员，其他');
            $table->string('name', 32)->default('')->comment('账户名');
            $table->string('action', 64)->default('')->comment('动作');
            $table->string('note', 256)->default('')->comment('备注');
            $table->string('ip',32)->default('')->comment('IP地址');
            $table->string('locate',128)->default('')->comment('地址详情');
            $table->string('user_agent',128)->default('')->comment('user_agent');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('admins');

        Schema::dropIfExists('system_permissions');
        Schema::dropIfExists('system_roles');
        Schema::dropIfExists('system_role_permission');
        Schema::dropIfExists('admin_role_admin');
        Schema::dropIfExists('system_configs');
        Schema::dropIfExists('login_logs');
        Schema::dropIfExists('menus');
        Schema::enableForeignKeyConstraints();
    }
}
