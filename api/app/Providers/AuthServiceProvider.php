<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Outlet;
use App\Policies\OutletPolicy;
use App\Lottery;
use App\Policies\LotteryPolicy;
use App\Prize;
use App\Policies\PrizePolicy;
use App\Winner;
use App\Policies\WinnerPolicy;
use App\Image;
use App\Policies\ImagePolicy;
use App\Video;
use App\Policies\VideoPolicy;
use App\Review;
use App\Policies\ReviewPolicy;
use App\Setting;
use App\Policies\SettingPolicy;
use App\User;
use App\Policies\UserPolicy;
use App\Banner;
use App\Policies\BannerPolicy;
use App\Ad;
use App\Policies\AdPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Image::class => ImagePolicy::class,
        Lottery::class => LotteryPolicy::class,
        Outlet::class => OutletPolicy::class,
        Prize::class => PrizePolicy::class,
        Review::class => ReviewPolicy::class,
        Setting::class => SettingPolicy::class,
        User::class => UserPolicy::class,
        Video::class => VideoPolicy::class,
        Winner::class => WinnerPolicy::class,
        Banner::class => BannerPolicy::class,
        Ad::class => AdPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
