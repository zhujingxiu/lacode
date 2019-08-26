<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 21:29
 */


Route::group(['prefix'=>'xadmin'], function () {

    Route::get('/login', '\App\Admin\Controllers\LoginController@index')->name('admin.login');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login')->name('admin.login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout')->name('admin.logout');

    // 需要登陆的
    Route::group(['middleware' => ['auth:admin','sso:admin']], function() {
        Route::get('/', '\App\Admin\Controllers\HomeController@index')->name('admin.home');
        Route::get('/home', '\App\Admin\Controllers\HomeController@index')->name('admin.home');
        Route::get('/online', '\App\Admin\Controllers\HomeController@online')->name('admin.online');
        //会员管理
        Route::get('/member', '\App\Admin\Controllers\MemberController@index')->name('admin.member');
        Route::get('/member/new', '\App\Admin\Controllers\MemberController@create')->name('admin.member-new');
        Route::get('/member/list', '\App\Admin\Controllers\MemberController@listData')->name('admin.member-list');
        Route::post('/member/store', '\App\Admin\Controllers\MemberController@store')->name('admin.member-store');
        Route::post('/member/disabled', '\App\Admin\Controllers\MemberController@disabled')->name('admin.member-disabled');
        Route::match(['get','post'],'/member/{member}/rebates', '\App\Admin\Controllers\MemberController@rebates')->name('admin.member-rebates');

        Route::get('/log', '\App\Admin\Controllers\ProfileController@log')->name('admin.log');
        Route::get('/password', '\App\Admin\Controllers\ProfileController@password')->name('admin.password');
        Route::post('/reset', '\App\Admin\Controllers\ProfileController@reset')->name('admin.reset');
        // 系统配置
        Route::get('/config', '\App\Admin\Controllers\ConfigController@index')->name('admin.config');
        Route::get('/config/store', '\App\Admin\Controllers\ConfigController@store')->name('admin.config-store');
        // 彩种管理
        Route::get('/games', '\App\Admin\Controllers\GameController@index')->name('admin.games');
        Route::get('/game/{game}/install', '\App\Admin\Controllers\GameController@install')->name('admin.game-install');
        Route::get('/game/{game}/uninstall', '\App\Admin\Controllers\GameController@uninstall')->name('admin.game-uninstall');
        Route::match(['get','post'], '/game/{game}/options', '\App\Admin\Controllers\GameController@options')->name('admin.game-options');
        Route::match(['get','post'], '/game/{game}/rebates', '\App\Admin\Controllers\GameController@rebates')->name('admin.game-rebates');
        Route::match(['get','post'], '/game/{game}/groups', '\App\Admin\Controllers\GameController@groups')->name('admin.game-groups');
        Route::match(['get','post'], '/game/{game}/bets', '\App\Admin\Controllers\GameController@bets')->name('admin.game-bets');
        Route::match(['get','post'], '/game/{game}/optionBets', '\App\Admin\Controllers\GameController@optionBets')->name('admin.game-option-bets');
        Route::match(['get','post'], '/game/{game}/odds', '\App\Admin\Controllers\GameController@odds')->name('admin.game-odds');
        Route::match(['get','post'], '/game/{game}/schedules', '\App\Admin\Controllers\GameController@schedules')->name('admin.game-schedules');
        Route::get('/game/{game}delete', '\App\Admin\Controllers\GameController@delete')->name('admin.game-delete');
        Route::get('/game/store', '\App\Admin\Controllers\Controllers\GameController@store')->name('admin.game-store');

        // 商户管理
        Route::get('/merchant/role/{code}', '\App\Admin\Controllers\MerchantController@index')->where('code', '[A-Za-z]+')->name('admin.merchant-users');
        Route::get('/merchant/{role}/new', '\App\Admin\Controllers\MerchantController@create')->name('admin.merchant-new');
        Route::get('/merchant/{role}/list', '\App\Admin\Controllers\MerchantController@listData')->name('admin.merchant-list');
        Route::post('/merchant/store', '\App\Admin\Controllers\MerchantController@store')->name('admin.merchant-store');
        Route::post('/merchant/disabled', '\App\Admin\Controllers\MerchantController@disabled')->name('admin.merchant-disabled');
        Route::match(['get','post'],'/merchant/{merchant}/rebates', '\App\Admin\Controllers\MerchantController@rebates')->name('admin.merchant-rebates');
        Route::match(['get','post'],'/merchant/games', '\App\Admin\Controllers\MerchantController@games')->name('admin.merchant-games');

        // 角色管理
        Route::get('/roles', '\App\Admin\Controllers\RoleController@index')->name('admin.role');
        Route::get('/roles/{code}/manager', '\App\Admin\Controllers\RoleController@managers')->where('code', '[A-Za-z]+')->name('admin.role-user');
        Route::post('/roles/new_user', '\App\Admin\Controllers\RoleController@newUser')->name('admin.role-new-user');
        Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store')->name('admin.role-store');
        Route::match(['get','post'], '/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission')->name('admin.role-permissions');

        // 权限管理
        Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index')->name('admin.permission');
        Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store')->name('admin.permission-store');
        Route::get('/permissions/routes', '\App\Admin\Controllers\PermissionController@routes')->name('admin.ajax-routes');

        //商户菜单管理
        Route::get('/menus','\App\Admin\Controllers\MenuController@index')->name('admin.menu.index');
        Route::post('/menus/store','\App\Admin\Controllers\MenuController@store')->name('admin.menu.store');
        Route::get('/menus/detail','\App\Admin\Controllers\MenuController@detail')->name('admin.menu.detail');
        Route::get('/menus/delete','\App\Admin\Controllers\MenuController@delete')->name('admin.menu.delete');
    });

});