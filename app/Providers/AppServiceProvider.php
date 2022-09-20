<?php

namespace App\Providers;

use App\Domain\Services\Account\AccountService;
use App\Infrastructure\Repositories\AccountRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccountService::class, function () {
            $accountRepository = new AccountRepository();

            return new AccountService(
                $accountRepository, 
            );
        });
    }
}
