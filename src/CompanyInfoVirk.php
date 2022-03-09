<?php

namespace Worksome\CompanyInfo;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class CompanyInfoVirk
{
    /**
     * Lookup a company name on the Danish Virk service, return processed company info.
     *
     * @param string $name Name of company to lookup.
     *
     * @return array|null Array of company info, or null if request to service failed.
     */
    public static function lookup(string $name): ?array
    {
        $response = Http::withBasicAuth(
            config('company-info.services.virk.user_id') ?? '',
            config('company-info.services.virk.password') ?? ''
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

        $companies = [];

        foreach (Arr::wrap($response->json('hits.hits')) as $company) {
            $companyData = $company['_source']['Vrvirksomhed'];

            $address = $companyData['virksomhedMetadata']['nyesteBeliggenhedsadresse'];

            $streetNumber = $address['husnummerTil']
                ? $address['husnummerFra'] . '-' . $address['husnummerTil']
                : $address['husnummerFra'];

            $floor = isset($address['etage']) ? ', ' . $address['etage'] . '.' : '';
            $floorDoor = isset($address['sidedoer']) ? ' ' . $address['sidedoer'] : '';

            $companies[] = [
                'number'  => $companyData['cvrNummer'],
                'name'    => $companyData['virksomhedMetadata']['nyesteNavn']['navn'],
                'address' => $address['vejnavn'] . ' ' . $streetNumber . $floor . $floorDoor,
                'zipCode' => $address['postnummer'],
                'city'    => $address['postdistrikt'],
                'country' => $address['landekode'],
            ];
        }

        return $companies;
    }
}
