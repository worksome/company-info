<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Providers;

use Illuminate\Http\Client\Factory as Client;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Worksome\CompanyInfo\Concerns\FakeResponse;
use Worksome\CompanyInfo\Contracts\CompanyInfoProvider;
use Worksome\CompanyInfo\DataObjects\CompanyInfo;

class GazetteProvider implements CompanyInfoProvider
{
    use FakeResponse;

    /**
     * Construct the provider.
     */
    public function __construct(
        private readonly Client $client,
        private readonly string $baseUrl,
        private readonly string $key,
        private readonly int $maxResults,
    ) {
    }

    /**
     * Lookup a company name, return processed company info.
     *
     * @param string $name    Name of company to lookup.
     * @param string $country Country code.
     *
     * @return array<CompanyInfo>|null Array of company info, or null if request failed.
     */
    public function lookupName(string $name, string $country = 'gb'): ?array
    {
        if ($this->fakeResponse) {
            return $this->fakeResponse;
        }

        $response = $this
            ->client
            ->withBasicAuth($this->key, '')
            ->get("{$this->baseUrl}/search/companies?q={$name}&items_per_page={$this->maxResults}");

        return self::processResponse($response);
    }

    /**
     * Lookup a company number, return processed company info.
     *
     * @param string $number Number of company to lookup.
     *
     * @return array<CompanyInfo>|null Array of company info, or null if request failed.
     */
    public function lookupNumber(string $number, string $country = 'gb'): ?array
    {
        if ($this->fakeResponse) {
            return $this->fakeResponse;
        }

        $response = $this
            ->client
            ->withBasicAuth($this->key, '')
            ->get("{$this->baseUrl}/search/companies?q={$number}&items_per_page={$this->maxResults}");

        return self::processResponse($response);
    }

    /**
     * Process the response.
     *
     * @param Response $response Response.
     *
     * @return array<CompanyInfo>|null Array of company info, or null if request failed.
     */
    private function processResponse(Response $response): ?array
    {
        if ($response->failed()) {
            return null;
        }

        $companies = [];

        foreach (Arr::wrap($response->json('items')) as $company) {
            if ($company['company_status'] !== 'active') {
                continue;
            }

            $address = $company['address'];

            $addressLine1 = $address['address_line_1'] ?? '';
            $addressLine2 = $address['address_line_2'] ?? '';
            if (empty($addressLine1)) {
                $addressLine1 = $addressLine2;
                $addressLine2 = '';
            }

            $premises = $address['premises'] ?? '';

            $country = $address['country'] ?? '';

            // We've seen Ireland as a country in the data.
            if ($country == 'Ireland') {
                $country = 'IE';
            } else {
                $country = 'GB';
            }

            $companies[] = new CompanyInfo(
                number: $company['company_number'],
                name: $company['title'],
                address1: empty($premises) ? $addressLine1 : "{$premises} {$addressLine1}",
                address2: $addressLine2,
                zipcode: $address['postal_code'] ?? '',
                city: $address['locality'] ?? '',
                country: $country,
            );
        }

        return $companies;
    }
}
