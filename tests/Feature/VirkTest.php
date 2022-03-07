<?php

use Illuminate\Support\Facades\Http;

it('can lookup a company name on dk virk service', function (string $lookupName, array $expected) {
    if (config('company-info.services.virk.user_id') == '') {
        test()->markTestSkipped();
    }

    if (config('company-info.services.virk.password') == '') {
        test()->markTestSkipped();
    }

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
                            'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn' => $lookupName
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

    expect($response->ok())->toBe(true);

    expect($response->json()['hits']['hits'])->toHaveCount(1);

    expect($response->json())->toHaveKey('hits.hits.0._source.Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn', $expected[0][1]);

    expect($response->json())->toHaveKey('hits.hits.0._source.Vrvirksomhed.cvrNummer', $expected[0][0]);
})->with('dk-companies');
