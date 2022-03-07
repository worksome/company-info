<?php

namespace Worksome\CompanyInfo\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelRay\RayServiceProvider;
use Worksome\CompanyInfo\CompanyInfoServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            CompanyInfoServiceProvider::class,
            RayServiceProvider::class,
        ];
    }
}
