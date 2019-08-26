<?php

namespace App\Http\Controllers;

use App\Repositories\MemberRepository;
use Illuminate\Http\Request;
class ProfileController extends Controller
{
    //
    public function index()
    {
        $member = MemberRepository::me();
        return ajax_return(1,[
            'username' => $member->name,
            'nick_name' => $member->nick_name,
            'credit' => $member->info->credit,
            'roulette' => strtoupper($member->info->roulette),
            'balance' => $member->info->balance,
        ]);
    }
    public function balance()
    {
        $balance = MemberRepository::balance();
        return ajax_return(1,compact('balance'));
    }


}
