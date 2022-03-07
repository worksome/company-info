<?php

namespace Worksome\CompanyInfo;

use Illuminate\Contracts\Foundation\Application;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Worksome\CompanyInfo\Commands\CompanyInfoLookupCommand;
use Worksome\CompanyInfo\Support\CompanyInfoManager;

final class CompanyInfoServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->singleton('exchange', Exchange::class);

        $this->app->bind(
            ExchangeRateProvider::class,
            fn (Application $app) => (new ExchangeRateManager($app))->driver()
        );

        $this->app->bind(CurrencyCodeProvider::class, FlatCurrencyCodeProvider::class);
        $this->app->bind(ValidatesCurrencyCodes::class, ValidateCurrencyCodes::class);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('company-info')
            ->hasConfigFile()
            ->hasCommand(CompanyInfoLookupCommand::class);
    }
}
