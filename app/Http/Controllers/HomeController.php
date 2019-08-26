<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;
use App\Libs\Merchant\Models\MerchantGame;
use App\Libs\Merchant\Models\MerchantRelation;
class HomeController extends Controller
{
    //
    public function index()
    {
        return view('member.home');
    }

    public function notice()
    {
        $notice = MemberRepository::memberNotices()->first()->toArray();
        return ajax_return(1, $notice);
    }
}
