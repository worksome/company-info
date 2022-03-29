<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Worksome\CompanyInfo\CompanyInfo
 */
final class CompanyInfo extends Facade
{
    public static function fake(array $lookup = [], array $response = []): void
    {
        /** @var \Worksome\CompanyInfo\CompanyInfo $fake */
        $fake = self::$app->instance(\Worksome\CompanyInfo\CompanyInfo::class, self::getFacadeRoot());

        $fake->fake($lookup, $response);
    }

    protected static function getFacadeAccessor(): string
    {
        return 'company-info';
    }
}
