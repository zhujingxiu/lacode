<?php


namespace App\Repositories;


use App\Libs\Game\Models\Game;
use App\Libs\Merchant\Models\Merchant;
use App\Libs\Merchant\Models\MerchantGame;
use App\Libs\Merchant\Models\MerchantRelation;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class MemberRepository
{
    public static function me()
    {
        $member = Auth::user();

        return $member;
    }

    public static function balance()
    {
        return self::me()->info->balance;
    }

    public static function memberCompany()
    {
        $member = self::me();
        $key = sprintf(config('site.member_company_key'),$member->id);
        $game = Redis::get($key);
        if(!$game){
            $company = Merchant::find(MerchantRelation::select('merchant_id')->where(['child_role'=>'member','user_id'=>$member->id,'parent_role'=>'company'])->first())->first();
            $value = json_encode($company->toArray());
            Redis::set($key, $value);
        }
        return json_decode($game, TRUE);
    }

    public static function memberGames()
    {
        $company = self::memberCompany();
        $games = MerchantGame::where(['merchant_id'=>$company['id'],'status'=>1])->get();

        $tmp = [];
        foreach($games as $key => $game){
            $gameEntiry = GameRepository::game($game['game_id']);
            $groups = GameRepository::gameGroups($gameEntiry['id']);
            $tmp[$gameEntiry['id']] = [
                'id' => $gameEntiry['id'],
                'title' => $gameEntiry['title'],
                'code' => $gameEntiry['code'],
                'groups' => $groups
            ];

        }
        return $tmp;
    }

    public static function memberNotices()
    {
        $notices = Notice::where(['member'=>1,'status'=>1])->get();

        return $notices;
    }
}