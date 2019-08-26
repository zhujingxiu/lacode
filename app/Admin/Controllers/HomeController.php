<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use \DB;
class HomeController extends Controller
{

    public function index()
    {
        $page_title = '后台首页';
        DB::table('game_schedule_issues')->where([['game_id','=',3],['issue','>','20190404121']])->update(['status'=>'1']);
        return view('admin.home.index', compact('page_title'));


    }

    public function online()
    {
        $page_title = '在线统计';
        return view('admin.home.online', compact('page_title'));
    }

}
