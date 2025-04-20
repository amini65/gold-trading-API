<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\TradeRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Repositories\Repos\OrderRepo;
use App\Repositories\Repos\TradeRepo;
use App\Repositories\Repos\UserRepo;
use App\Repositories\Repos\WalletRepo;
use App\Services\Contracts\MatchingServiceInterface;
use App\Services\Contracts\OrderServiceInterface;
use App\Services\Contracts\TradingServiceInterface;
use App\Services\Contracts\WalletServiceInterface;
use App\Services\MatchingService;
use App\Services\OrderService;
use App\Services\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Repositories
        $this->app->bind(OrderRepositoryInterface::class , OrderRepo::class);
        $this->app->bind(WalletRepositoryInterface::class , WalletRepo::class);
        $this->app->bind(TradeRepositoryInterface::class , TradeRepo::class);

        //Services
        $this->app->bind(MatchingServiceInterface::class, MatchingService::class);
        $this->app->bind(WalletServiceInterface::class, WalletService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
    }
}
