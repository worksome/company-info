<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Providers;

use Illuminate\Http\Client\Factory as Client;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Worksome\CompanyInfo\Contracts\CompanyInfoProvider;
use Worksome\CompanyInfo\DataObjects\CompanyInfo;

class CvrApiProvider implements CompanyInfoProvider
{
    /**
     * Construct the provider.
     */
    public function __construct(
        private Client $client,
        private string $baseUrl,
        private string $userAgent,
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
    public function lookupName(string $name, string $country = 'dk'): ?array
    {
        $response = $this
            ->client
            ->withHeaders($this->getHeaders())
            ->get("{$this->baseUrl}?name={$name}&country={$country}");

        return $this->processResponse($response, $country);
    }

    /**
     * Lookup a company number, return processed company info.
     *
     * @param string $number  Number of company to lookup.
     * @param string $country Country code.
     *
     * @return array<CompanyInfo>|null Array of company info, or null if request failed.
     */
    public function lookupNumber(string $number, string $country = 'dk'): ?array
    {
        $response = $this
            ->client
            ->withHeaders($this->getHeaders())
            ->get("{$this->baseUrl}?vat={$number}&country={$country}");

        return $this->processResponse($response, $country);
    }

    /**
     * Process the response.
     *
     * @param Response $response Response.
     * @param string   $country  Country code.
     *
     * @return array<CompanyInfo>|null Array of company info, or null if request failed.
     */
    private function processResponse(Response $response, string $country): ?array
    {
        if ($response->failed()) {
            return null;
        }

        if ($response->json('error')) {
            return null;
        }

        $company = Arr::wrap($response->json());

        // Do not return dead companies.
        if (! empty($company['enddate'])) {
            return [];
        }

        $companies[] = new CompanyInfo(
            number:   (string) $company['vat'],
            name:     (string) $company['name'],
            address1: (string) $company['address'],
            address2: (string) $company['cityname'],
            zipcode:  (string) $company['zipcode'],
            city:     (string) $company['city'],
            country:  (string) $country,
            phone:    (string) $company['phone'],
            email:    (string) $company['email'],
        );

        return $companies;
    }

    /**
     * Get headers for the CVR API call.
     *
     * @return array Headers.
     */
    private function getHeaders(): array
    {
        return empty($this->userAgent) ? [] : ['User-Agent' => $this->userAgent];
    }
}
