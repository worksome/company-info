<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo;

use Illuminate\Contracts\Foundation\Application;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Worksome\CompanyInfo\CompanyInfo;
use Worksome\CompanyInfo\Commands\CompanyInfoLookupCommand;
use Worksome\CompanyInfo\Support\CompanyInfoManager;

final class CompanyInfoServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->singleton('company-info', CompanyInfo::class);

        $this->app->bind(
            CompanyInfo::class,
            fn (Application $app) => new CompanyInfo(
                $app->get('config')->get('company-info'),
                $app->get(CompanyInfoManager::class)
            )
        );
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('company-info')
            ->hasConfigFile()
            ->hasCommand(CompanyInfoLookupCommand::class);
    }
}
