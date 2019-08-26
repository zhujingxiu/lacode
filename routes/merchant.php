<?php

Route::group(['prefix'=>'xmerchant', 'namespace'=>'Merchant'], function () {

    Route::get('/login', 'LoginController@index')->name('merchant.login');
    Route::post('/login', 'LoginController@login')->name('merchant.login');
    Route::get('/logout', 'LoginController@logout')->name('merchant.logout');

    // 需要登陆的
    Route::group(['middleware' => ['auth:merchant','sso:merchant','initialize:merchant']], function() {
        Route::get('/', 'HomeController@index')->name('merchant.home');
        Route::get('/home', 'HomeController@index')->name('merchant.home');
        Route::get('/online', 'HomeController@online')->name('merchant.online');
        Route::get('/notice', 'HomeController@notice')->name('merchant.notice');
        Route::get('/lottery', 'HomeController@lottery')->name('merchant.lottery');

        Route::get('/log', 'ProfileController@log')->name('merchant.log');
        Route::get('/pwd', 'ProfileController@pwd')->name('merchant.password');
        Route::post('/reset', 'ProfileController@reset')->name('merchant.reset');


        Route::get('/notice/index', 'NoticeController@index')->name('merchant.notice');
        Route::get('/notice/create', 'NoticeController@create')->name('merchant.notice-create');
        Route::get('/notice/update/{notice}', 'NoticeController@update')->name('merchant.notice-update');
        Route::get('/notice/delete/{notice}', 'NoticeController@delete')->name('merchant.notice-delete');
        Route::post('/notice/store', 'NoticeController@store')->name('merchant.notice-store');
        //用户管理
        Route::get('/user/company', 'MerchantController@company')->name('merchant.user-company');
        Route::get('/user/shareholder', 'MerchantController@shareholder')->name('merchant.user-shareholder');
        Route::get('/user/agent', 'MerchantController@agent')->name('merchant.user-agent');
        Route::get('/user/proxy', 'MerchantController@proxy')->name('merchant.user-proxy');
        Route::match(['get','post'],'/user/admin', 'MerchantController@admin')->name('merchant.user-admin');
        Route::get('/user/create/{code}', 'MerchantController@create')->name('merchant.user-create');
        Route::post('/user/store', 'MerchantController@store')->name('merchant.user-store');
        Route::get('/user/check', 'MerchantController@check')->name('merchant.user-check');
        Route::match(['get','post'],'/user/rebate/{merchant}', 'MerchantController@rebate')->name('merchant.user-rebate');
        Route::get('/user/edit/{merchant}', 'MerchantController@edit')->name('merchant.user-edit');
        Route::get('/user/log/{merchant}', 'MerchantController@log')->name('merchant.user-log');
        Route::get('/user/history/{merchant}', 'MerchantController@history')->name('merchant.user-history');
        Route::get('/user/delete/{merchant}', 'MerchantController@delete')->name('merchant.user-delete');
        Route::get('/user/merchants', 'MerchantController@merchants')->name('merchant.user-merchants');
        Route::get('/user/merchant', 'MerchantController@merchant')->name('merchant.user-merchant');
        Route::get('/user/offline', 'MerchantController@offline')->name('merchant.user-offline');

        Route::get('/member', 'MemberController@index')->name('merchant.member');
        Route::get('/member/create', 'MemberController@create')->name('merchant.member-create');
        Route::post('/member/store', 'MemberController@store')->name('merchant.member-store');
        Route::get('/member/check', 'MemberController@check')->name('merchant.member-check');
        Route::get('/member/edit/{member}', 'MemberController@edit')->name('merchant.member-edit');
        Route::match(['get','post'],'/member/rebate/{member}', 'MemberController@rebate')->name('merchant.member-rebate');
        Route::get('/member/log/{member}', 'MemberController@log')->name('merchant.member-log');
        Route::get('/member/history/{member}', 'MemberController@history')->name('merchant.member-history');
        Route::match(['get','post'],'/member/recharge/{member}', 'MemberController@recharge')->name('merchant.member-recharge');
        Route::get('/member/merchants', 'MemberController@merchants')->name('merchant.member-merchants');
        Route::get('/member/merchant', 'MemberController@merchant')->name('merchant.member-merchant');
        // 系统配置
        Route::get('/config', 'ConfigController@index')->name('merchant.config');
        Route::post('/config/store', 'ConfigController@store')->name('merchant.config-store');
        Route::match(['get','post'],'/config/odds', 'ConfigController@odds')->name('merchant.config-odds');
        Route::match(['get','post'],'/config/odds_diff', 'ConfigController@oddsDiff')->name('merchant.config-odds-diff');
        Route::match(['get','post'],'/config/odds_diff', 'ConfigController@oddsDiff')->name('merchant.config-odds-diff');
        Route::match(['get','post'],'/config/lottery', 'ConfigController@lottery')->name('merchant.config-lottery');
        Route::match(['get','post'],'/config/schedule', 'ConfigController@schedule')->name('merchant.config-schedule');
        Route::match(['get','post'],'/config/rebate', 'ConfigController@rebate')->name('merchant.config-rebate');

        //注单
        Route::get('/order', 'OrderController@index')->name('merchant.config');
        Route::get('/order/index', 'OrderController@index')->name('merchant.config');
        Route::get('/order/clear', 'OrderController@clear')->name('merchant.order-clear');
        Route::get('/order/repair', 'OrderController@repair')->name('merchant.order-repair');
        Route::get('/order/fresh', 'OrderController@fresh')->name('merchant.order-fresh');
        Route::get('/order/bet/{gameGroup}', 'OrderController@bet')->name('merchant.order-bet');
    });

});