<?php

namespace Worksome\CompanyInfo;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Worksome\CompanyInfo\Commands\CompanyInfoLookupCommand;

final class CompanyInfoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('company-info')
            ->hasConfigFile()
            ->hasCommand(CompanyInfoLookupCommand::class);
    }
}
