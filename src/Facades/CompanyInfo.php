<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Worksome\CompanyInfo\CompanyInfo
 */
final class CompanyInfo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'company-info';
    }
}
