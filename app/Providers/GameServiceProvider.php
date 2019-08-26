<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\Game\Lottery\GameJssc;
use App\Libs\Game\Lottery\GameJsssc;
use App\Libs\Game\Lottery\GameCqssc;
use App\Libs\Game\Lottery\GamePk10;
use App\Libs\Game\Lottery\GameXyft;

use App\Libs\Merchant\Role\MerchantAdmin;
use App\Libs\Merchant\Role\MerchantCompany;
use App\Libs\Merchant\Role\MerchantShareholder;
use App\Libs\Merchant\Role\MerchantAgent;
use App\Libs\Merchant\Role\MerchantProxy;
use App\Libs\Merchant\Role\Member;
class GameServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GameCqssc::class, function ($app){
            new GameCqssc($app['request']['game']);
        });
        $this->app->singleton(GamePk10::class, function ($app){
            new GamePk10($app['request']['game']);
        });
        $this->app->singleton(GameJssc::class, function ($app){
            new GameJssc($app['request']['game']);
        });
        $this->app->singleton(GameJsssc::class, function ($app){
            new GameJsssc($app['request']['game']);
        });
        $this->app->singleton(GameXyft::class, function ($app){
            new GameXyft($app['request']['game']);
        });

        $this->app->singleton(MerchantAdmin::class, function ($app){
            new MerchantAdmin($app['request']['code']);
        });
        $this->app->singleton(MerchantShareholder::class, function ($app){
            new MerchantShareholder($app['request']['code']);
        });

        $this->app->singleton(MerchantCompany::class, function ($app){
            new MerchantCompany($app['request']['code']);
        });
        $this->app->singleton(MerchantAgent::class, function ($app){
            new MerchantAgent($app['request']['code']);
        });

        $this->app->singleton(MerchantProxy::class, function ($app){
            new MerchantProxy($app['request']['code']);
        });

        $this->app->singleton(Member::class, function ($app){
            new Member($app['request']['code']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [GamePk10::class, GameCqssc::class, GameJsssc::class, GameJssc::class, GameXyft::class,
            MerchantAdmin::class, MerchantCompany::class, MerchantShareholder::class, MerchantAgent::class, MerchantProxy::class,
            Member::class];
    }
}
