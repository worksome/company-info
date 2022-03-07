<?php

use Illuminate\Support\Facades\Http;

it('can lookup a company name on the uk gazette service', function (string $lookupName, array $expected) {
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    $response = Http::withBasicAuth(
        config('company-info.services.gazette.key'),
        ''
    )->get(config('company-info.services.gazette.base_url') . '/search/companies?q=' . $lookupName);

    expect($response->ok())->toBe(true);

    expect($response->json()['items'])->toHaveCount(1);

    expect($response->json())->toHaveKey('items.0.title', $expected[0][1]);

    expect($response->json())->toHaveKey('items.0.company_number', $expected[0][0]);
})->with('uk-companies');
