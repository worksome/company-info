<?php

namespace Worksome\CompanyInfo;

use Illuminate\Support\Facades\Http;

class CompanyInfo
{
    public function lookup(string $name, string $market): ?array
    {
        switch ($market) {
            case 'dk':
                return $this->lookupVirk($name);
            case 'uk':
                return $this->lookupGazette($name);
            default:
                return null;
        }
    }

    public function lookupVirk(string $name): ?array
    {
        $response = Http::withBasicAuth(
            config('company-info.services.virk.user_id'),
            config('company-info.services.virk.password')
        )->post(
            config('company-info.services.virk.base_url') . '/cvr-permanent/virksomhed/_search',
            [
                '_source' => [
                    'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn',
                    'Vrvirksomhed.cvrNummer',
                    'Vrvirksomhed.virksomhedMetadata.nyesteBeliggenhedsadresse',
                ],
                'query' => [
                    'bool' => [
                        'must' => [
                            'prefix' => [
                                // Get companies starting with this name.
                                'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn' => $name
                            ],
                        ],
                        'must_not' => [
                            'exists' => [
                                // Only query for existing companies.
                                'field' => 'Vrvirksomhed.livsforloeb.periode.gyldigTil',
                            ],
                        ],
                    ],
                ],
                'from' => 0,
                'size' => 10,
                'sort' => [],
            ]
        );

        if ($response->failed()) {
            return null;
        }

        $companies = $response->json('hits.hits');

        $simpleCompanies = [];

        foreach ($companies as $company) {
            $companyData = $company['_source']['Vrvirksomhed'];

            $address = $companyData['virksomhedMetadata']['nyesteBeliggenhedsadresse'];

            $streetNumber = $address['husnummerTil']
                ? $address['husnummerFra'] . '-' . $address['husnummerTil']
                : $address['husnummerFra'];

            $floor = isset($address['etage']) ? ', ' . $address['etage'] . '.' : '';
            $floorDoor = isset($address['sidedoer']) ? ' ' . $address['sidedoer'] : '';

            $simpleCompanies[] = [
                'number'  => $companyData['cvrNummer'],
                'name'    => $companyData['virksomhedMetadata']['nyesteNavn']['navn'],
                'address' => $address['vejnavn'] . ' ' . $streetNumber . $floor . $floorDoor,
                'zipCode' => $address['postnummer'],
                'city'    => $address['postdistrikt'],
                'country' => $address['landekode'],
            ];
        }

        return $simpleCompanies;
    }

    public function lookupGazette(string $name): ?array
    {
        $response = Http::withBasicAuth(
            config('company-info.services.gazette.key'),
            ''
        )->get(config('company-info.services.gazette.base_url') . '/search/companies?q=' . $name);

        if ($response->failed()) {
            return null;
        }

        $companies = $response->json('items');

        $simpleCompanies = [];

        foreach ($companies as $company) {
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

                $simpleCompanies[] = [
                    'number'  => $company['company_number'],
                    'name'    => $company['title'],
                    'address' => empty($premises) ? $addressLine : $premises . ' ' . $addressLine,
                    'zipCode' => isset($address['postal_code']) ? $address['postal_code'] : '',
                    'city'    => isset($address['locality']) ? $address['locality'] : '',
                    'country' => $country,
                ];
            }
        }

        return $simpleCompanies;
    }
}
