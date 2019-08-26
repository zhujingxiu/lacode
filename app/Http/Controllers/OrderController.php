<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use App\Repositories\MemberRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
    }

    public function betting(Request $request)
    {
        dd($request->all());
        return ajax_return(1,compact('group','game'));
    }



}
