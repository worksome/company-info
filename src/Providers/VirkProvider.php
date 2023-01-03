<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Providers;

use Illuminate\Http\Client\Factory as Client;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Worksome\CompanyInfo\Concerns\FakeResponse;
use Worksome\CompanyInfo\Contracts\CompanyInfoProvider;
use Worksome\CompanyInfo\DataObjects\CompanyInfo;

class VirkProvider implements CompanyInfoProvider
{
    use FakeResponse;

    /**
     * Construct the provider.
     */
    public function __construct(
        private readonly Client $client,
        private readonly string $baseUrl,
        private readonly string $userId,
        private readonly string $password,
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
    public function lookupName(string $name, string $country = 'dk'): ?array
    {
        if ($this->fakeResponse) {
            return $this->fakeResponse;
        }

        $response = $this
            ->client
            ->withBasicAuth($this->userId, $this->password)
            ->post(
                "{$this->baseUrl}/cvr-permanent/virksomhed/_search",
                [
                    '_source' => [
                        'Vrvirksomhed.cvrNummer',
                        'Vrvirksomhed.elektroniskPost',
                        'Vrvirksomhed.telefonNummer',
                        'Vrvirksomhed.virksomhedMetadata.nyesteBeliggenhedsadresse',
                        'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn',
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
                    'size' => $this->maxResults,
                    'sort' => [],
                ]
            );

        return $this->processResponse($response);
    }

    /**
     * Lookup a company number, return processed company info.
     *
     * @param string $number Number of company to lookup.
     *
     * @return array<CompanyInfo>|null Array of company info, or null if request failed.
     */
    public function lookupNumber(string $number, string $country = 'dk'): ?array
    {
        if ($this->fakeResponse) {
            return $this->fakeResponse;
        }

        $response = $this
            ->client
            ->withBasicAuth($this->userId, $this->password)
            ->post(
                "{$this->baseUrl}/cvr-permanent/virksomhed/_search",
                [
                    '_source' => [
                        'Vrvirksomhed.cvrNummer',
                        'Vrvirksomhed.elektroniskPost',
                        'Vrvirksomhed.telefonNummer',
                        'Vrvirksomhed.virksomhedMetadata.nyesteBeliggenhedsadresse',
                        'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn',
                    ],
                    'query' => [
                        'term' => [
                            'Vrvirksomhed.cvrNummer' => $number
                        ],
                    ],
                    'from' => 0,
                    'size' => $this->maxResults,
                    'sort' => [],
                ]
            );

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

        foreach (Arr::wrap($response->json('hits.hits')) as $company) {
            $companyData = $company['_source']['Vrvirksomhed'];

            $address = $companyData['virksomhedMetadata']['nyesteBeliggenhedsadresse'];

            $streetNumber = $address['husnummerTil']
                ? $address['husnummerFra'] . '-' . $address['husnummerTil']
                : $address['husnummerFra'];

            $floor = isset($address['etage']) ? ', ' . $address['etage'] . '.' : '';
            $floorDoor = isset($address['sidedoer']) ? ' ' . $address['sidedoer'] : '';

            $companies[] = new CompanyInfo(
                number: (string) $companyData['cvrNummer'],
                name: (string) $companyData['virksomhedMetadata']['nyesteNavn']['navn'],
                address1: (string) $address['vejnavn'] . ' ' . $streetNumber . $floor . $floorDoor,
                address2: (string) $address['bynavn'],
                zipcode: (string) $address['postnummer'],
                city: (string) $address['postdistrikt'],
                country: (string) $address['landekode'],
                phone: (string) Arr::get($companyData, 'telefonNummer.0.kontaktoplysning'),
                email: (string) Arr::get($companyData, 'elektroniskPost.0.kontaktoplysning'),
            );
        }

        return $companies;
    }
}
