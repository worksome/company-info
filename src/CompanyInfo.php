<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo;

use Worksome\CompanyInfo\Contracts\CompanyInfoProvider;
use Worksome\CompanyInfo\Exceptions\InvalidCountryException;
use Worksome\CompanyInfo\Support\CompanyInfoManager;

class CompanyInfo
{
    /**
     * Construct the provider.
     */
    public function __construct(
        private array $config,
        private CompanyInfoManager $manager,
    ) {
    }

    /**
     * Lookup a company name, return processed company info.
     *
     * @param string $name    Name of company to lookup.
     * @param string $country Country code or '' for default country.
     *
     * @return array<\Worksome\CompanyInfo\DataObjects\CompanyInfo>|null Array of company info, or null if request failed.
     *
     * @throws InvalidCountryException If given country is not supported.
     */
    public function lookupName(string $name, string $country = ''): ?array
    {
        $country = empty($country) ? $this->config['default-country'] : $country;

        if (! $this->isSupportedCountry($country)) {
            throw new InvalidCountryException($country);
        }

        return $this->getProvider($country)->lookupName($name, $country);
    }

    /**
     * Lookup a company number, return processed company info.
     *
     * @param string $number  Number of company to lookup.
     * @param string $country Country code or '' for default country.
     *
     * @return array<\Worksome\CompanyInfo\DataObjects\CompanyInfo>|null Array of company info, or null if request failed.
     *
     * @throws InvalidCountryException If given country is not supported.
     */
    public function lookupNumber(string $number, string $country): ?array
    {
        $country = empty($country) ? $this->config['default-country'] : $country;

        if (! $this->isSupportedCountry($country)) {
            throw new InvalidCountryException($country);
        }

        return $this->getProvider($country)->lookupNumber($number, $country);
    }

    /**
     * Check if given country is supported.
     *
     * @param string $country Country code.
     *
     * @return bool True if supported, false if not.
     */
    private function isSupportedCountry(string $country): bool
    {
        return collect($this->config['countries'])->has($country);
    }

    /**
     * Get provider for the given country.
     *
     * @param string $country Country code.
     *
     * @return CompanyInfoProvider
     */
    private function getProvider(string $country)
    {
        $providerName = $this->config['countries'][$country]['provider'];

        return $this->manager->driver($providerName);
    }
}
