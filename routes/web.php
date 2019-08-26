<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', 'AuthController@index')->name('member.login');
Route::post('/login', 'AuthController@login')->name('member.login');
Route::get('/logout', 'AuthController@logout')->name('member.logout');
Route::group(['middleware' => ['auth','sso']], function() {
    Route::get('/', 'HomeController@index')->name('member.home');
    Route::get('/home', 'HomeController@index')->name('member.home');
    Route::get('/notice', 'HomeController@notice')->name('member.notice');

    Route::get('/profile', 'ProfileController@index')->name('member.profile');
    Route::get('/balance', 'ProfileController@balance')->name('member.balance');

    Route::get('/games', 'GameController@games')->name('member.games');
    Route::get('/group', 'GameController@group')->name('member.group');
    Route::get('/last', 'GameController@lastIssue')->name('member.last');
    Route::get('/latest', 'GameController@latest')->name('member.latest');
    Route::get('/counts', 'GameController@counts')->name('member.counts');
    Route::get('/opening', 'GameController@opening')->name('member.opening');
    Route::get('/odds', 'GameController@odds')->name('member.odds');

    Route::get('/order', 'OrderController@index')->name('member.order');
    Route::post('/betting', 'OrderController@betting')->name('member.buy');
});


include_once 'merchant.php';
include_once 'admin.php';
