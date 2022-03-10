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
     * @param string $market Market code.
     *
     * @return array|null Array of company info, or null if request to service failed.
     *
     * @throws InvalidMarketException If given market is not supported.
     */
    public static function lookupName(string $name, string $market): ?array
    {
        switch ($market) {
            case 'dk':
                return CompanyInfoVirk::lookupName($name);
            case 'uk':
                return CompanyInfoGazette::lookupName($name);
            default:
                throw new InvalidMarketException($market);
        }
    }

    /**
     * Lookup a company from number on a service given a market, return processed company info.
     *
     * @param string $number Number of company to lookup.
     * @param string $market Market code.
     *
     * @return array|null Array of company info, or null if request to service failed.
     *
     * @throws InvalidMarketException If given market is not supported.
     */
    public static function lookupNumber(string $number, string $market): ?array
    {
        switch ($market) {
            case 'dk':
                return CompanyInfoVirk::lookupNumber($number);
            case 'uk':
                return CompanyInfoGazette::lookupNumber($number);
            default:
                throw new InvalidMarketException($market);
        }
    }
}
