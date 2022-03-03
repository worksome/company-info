<?php

namespace Worksome\CompanyInfo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Worksome\CompanyInfo\CompanyInfo
 */
class CompanyInfo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'company-info';
    }
}
