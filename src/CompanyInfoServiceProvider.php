<?php

namespace Worksome\CompanyInfo;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Worksome\CompanyInfo\Commands\CompanyInfoCommand;

class CompanyInfoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('company-info')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_company-info_table')
            ->hasCommand(CompanyInfoCommand::class);
    }
}
