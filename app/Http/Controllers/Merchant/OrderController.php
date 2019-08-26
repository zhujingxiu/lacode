<?php

namespace App\Http\Controllers\Merchant;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libs\Game\Models\GameGroup;
class OrderController extends Controller
{
    //
    //注单管理
    public function index()
    {
        $orders = Order::with(['member','game'])->paginate(20);

        return view('merchant.order.index',compact('orders'));
    }
    //数据清理
    public function clear()
    {

    }

    //删改管理
    public function repair()
    {

    }
    //即时注单
    public function bet(GameGroup $gameGroup)
    {
        $oddsOptions = $gameGroup->load('oddsOptions')->orderBy('sort');
        return view('merchant.order.bet', compact('oddsOptions'));
    }
    //即时滚单
    public function fresh()
    {

    }


}
