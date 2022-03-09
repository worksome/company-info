<?php

namespace Worksome\CompanyInfo;

use Worksome\CompanyInfo\Exceptions\InvalidMarketException;

class CompanyInfo
{
    /**
     * Lookup a company name on a service given a market, return processed company info.
     *
     * @param string $name   Name of company to lookup.
     * @param string $market Market code.
     *
     * @return array|null Array of company info, or null if request to service failed.
     *
     * @throws InvalidMarketException If given market is not supported.
     */
    public static function lookup(string $name, string $market): ?array
    {
        switch ($market) {
            case 'dk':
                return CompanyInfoVirk::lookup($name);
            case 'uk':
                return CompanyInfoGazette::lookup($name);
            default:
                throw new InvalidMarketException($market);
        }
    }
}
