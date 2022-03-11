<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class CompanyInfoGazette
{
    /**
     * Lookup a company name on the English Gazette service, return processed company info.
     *
     * TODO: Should probably do a more specific query for the name, if possible?
     *
     * @param string $name Name of company to lookup.
     *
     * @return array|null Array of company info, or null if request to service failed.
     */
    public static function lookupName(string $name): ?array
    {
        // @phpstan-ignore-next-line
        $response = Http::withBasicAuth(config('company-info.services.gazette.key'), '')
            ->get(config('company-info.services.gazette.base_url') . "/search/companies?q={$name}");

        return self::processResponse($response);
    }

    /**
     * Lookup a company from number on the English Gazette service, return processed company info.
     *
     * TODO: Should probably do a more specific query for the number, if possible?
     *
     * @param string $number Number of company to lookup.
     *
     * @return array|null Array of company info, or null if request to service failed.
     */
    public static function lookupNumber(string $number): ?array
    {
        // @phpstan-ignore-next-line
        $response = Http::withBasicAuth(config('company-info.services.gazette.key'), '')
            ->get(config('company-info.services.gazette.base_url') . "/search/companies?q={$number}");

        return self::processResponse($response);
    }

    /**
     * Process the response from the Virk API call.
     *
     * @param Response $response Response.
     *
     * @return array|null Array of company info, or null if request to service failed.
     */
    private static function processResponse(Response $response): ?array
    {
        if ($response->failed()) {
            return null;
        }

        $companies = [];

        foreach (Arr::wrap($response->json('items')) as $company) {
            if ($company['company_status'] == 'active') {
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

                $companies[] = [
                    'number'   => $company['company_number'],
                    'name'     => $company['title'],
                    'address1' => empty($premises) ? $addressLine1 : "{$premises} {$addressLine1}",
                    'address2' => $addressLine2,
                    'zipcode'  => $address['postal_code'] ?? '',
                    'city'     => $address['locality'] ?? '',
                    'country'  => $country,
                ];
            }
        }

        return $companies;
    }
}
