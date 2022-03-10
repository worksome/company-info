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
     * @param string $name Name of company to lookup.
     *
     * @return array|null Array of company info, or null if request to service failed.Vir
     */
    public static function lookupName(string $name): ?array
    {
        // @phpstan-ignore-next-line
        $response = Http::withBasicAuth(config('company-info.services.gazette.key'), '')
            ->get(config('company-info.services.gazette.base_url') . "/search/companies?q={$name}");

        if ($response->failed()) {
            return null;
        }

        return self::processResponse($response);
    }

    /**
     * Lookup a company from number on the English Gazette service, return processed company info.
     *
     * @param string $number Number of company to lookup.
     *
     * @return array|null Array of company info, or null if request to service failed.
     */
    public static function lookupNumber(string $number): ?array
    {
        // @TODO: Not implemented yet.

        return null;
    }

    /**
     * Process the response from the Virk API call.
     *
     * @param Response $response Response.
     *
     * @return array Array of company info.
     */
    private static function processResponse(Response $response): array
    {
        $companies = [];

        foreach (Arr::wrap($response->json('items')) as $company) {
            if ($company['company_status'] == 'active') {
                $address = $company['address'];

                // Some address data might be missing.
                $addressLine = isset($address['address_line_1']) ? $address['address_line_1'] : '';
                if (empty($addressLine)) {
                    $addressLine = isset($address['address_line_2']) ? $address['address_line_2'] : '';
                }

                $premises = isset($address['premises']) ? $address['premises'] : '';

                $country = isset($address['country']) ? $address['country'] : '';

                // We've seen Ireland as a country in the data.
                if ($country == 'Ireland') {
                    $country = 'IE';
                } else {
                    $country = 'GB';
                }

                $companies[] = [
                    'number'  => $company['company_number'],
                    'name'    => $company['title'],
                    'address' => empty($premises) ? $addressLine : $premises . ' ' . $addressLine,
                    'zipCode' => isset($address['postal_code']) ? $address['postal_code'] : '',
                    'city'    => isset($address['locality']) ? $address['locality'] : '',
                    'country' => $country,
                ];
            }
        }

        return $companies;
    }
}
