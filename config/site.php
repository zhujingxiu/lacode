<?php

return [

    'login_guard' => 'login_guard',
    'login_token' => 'login_token',
    'admin_login_token' => 'admin_login_token',
    'merchant_login_token' => 'merchant_login_token',
    'admin_menu_key' => 'admin_menus',
    'merchant_menu_key' => 'merchant_menus',
    'merchant_game_key' => 'merchant_games',
    'game_namespace' => '\App\Libs\Game\Lottery',
    'merchant_namespace' => '\App\Libs\Merchant\Role',


    //RedisKey
    'last_issue_key' =>'last_issue_%s',
    'latest_issue_lotteries_key' =>'latest_issue_lotteries_%s',
    'latest_counts_lotteries_key' =>'latest_counts_lotteries_%s',
    'opening_issue_key' =>'opening_issue_%s',

    'game_key' => 'game_%s',
    'game_groups_key' => 'game_groups_%s',
    'game_group_key' => 'game_group_%s',
    'game_options_key' => 'game_options_%s',
    'game_option_key' => 'game_option_%s',
    'game_bets_key' => 'game_bets_%s',
    'game_bet_key' => 'game_bet_%s',
    'game_group_odds_key' => 'game_group_odds_%s',
    'game_group_refresh_second' => 90,


    'group_odds_key' => 'group_odds_%s_%s',
    'member_company_key' => 'member_company_%s',
];
