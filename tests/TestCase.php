<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Worksome\CompanyInfo\CompanyInfoServiceProvider;

class TestCase extends Orchestra
{
    /** {@inheritdoc} */
    protected function getPackageProviders($app): array
    {
        return [
            CompanyInfoServiceProvider::class,
        ];
    }
}
