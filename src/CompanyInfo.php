<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo;

use Worksome\CompanyInfo\Exceptions\InvalidMarketException;

class CompanyInfo
{
    /**
     * Lookup a company from name on a service given a market, return processed company info.
     *
     * @param string $name   Name of company to lookup.
     * @param string $market Market code or '' for default market.
     *
     * @return array|null Array of company info, or null if request to service failed.
     *
     * @throws InvalidMarketException If given market is not supported.
     */
    public static function lookupName(string $name, string $market = ''): ?array
    {
        $market = empty($market) ? config('company-info.default-market') : $market;

        switch ($market) {
            case 'dk':
                return CompanyInfoVirk::lookupName($name);
            case 'uk':
                return CompanyInfoGazette::lookupName($name);
            default:
                // @phpstan-ignore-next-line
                throw new InvalidMarketException($market);
        }
    }

    /**
     * Lookup a company from number on a service given a market, return processed company info.
     *
     * @param string $number Number of company to lookup.
     * @param string $market Market code or '' for default market.
     *
     * @return array|null Array of company info, or null if request to service failed.
     *
     * @throws InvalidMarketException If given market is not supported.
     */
    public static function lookupNumber(string $number, string $market): ?array
    {
        $market = empty($market) ? config('company-info.default-market') : $market;

        switch ($market) {
            case 'dk':
                return CompanyInfoVirk::lookupNumber($number);
            case 'uk':
                return CompanyInfoGazette::lookupNumber($number);
            default:
                // @phpstan-ignore-next-line
                throw new InvalidMarketException($market);
        }
    }
}
