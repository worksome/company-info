<?php

use Illuminate\Support\Facades\Http;

it('can lookup company name on dk virk service', function () {

    $name = 'Worksome';

    // Build request payload.
    $payload = [
        '_source' => [
            'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn',
            'Vrvirksomhed.cvrNummer',
            'Vrvirksomhed.virksomhedMetadata.nyesteBeliggenhedsadresse',
        ],
        'query' => [
            // 'term' => [
            //     'Vrvirksomhed.cvrNummer' => '37990485',
            // ],
            // 'wildcard' => [
            //     'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn' => $name . '*'
            // ],
            // 'prefix' => [
            //     'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn' => $name
            // ],
            'query_string' => [
                'default_field' => 'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn',
                'query' => $name,
            ],
            // 'bool' => [
            //     'must' => [
            //         'prefix' => [
            //             // Get companies starting with this name.
            //             'Vrvirksomhed.virksomhedMetadata.nyesteNavn.navn' => $name
            //         ],
            //     ],
            //     'must_not' => [
            //         'exists' => [
            //             // Only query for existing companies.
            //             'field' => 'Vrvirksomhed.livsforloeb.periode.gyldigTil',
            //         ],
            //     ],
            // ],
        ],
        'from' => 0,
        'size' => 10,
        'sort' => [],
    ];

    // Make the Virk API request.
    $response = Http::withBasicAuth(
        config('company-info.services.virk.user_id'),
        config('company-info.services.virk.password')
    )->post(
        config('company-info.services.virk.base_url') . '/cvr-permanent/virksomhed/_search',
        $payload
    );

    ray($response->status());
    expect($response->ok())->toBe(true);

    ray([
        'body'      => $response->json(),
        'companies' => $response->json()['hits']['hits'],
    ]);
});
