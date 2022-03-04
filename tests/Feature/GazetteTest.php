<?php

use Illuminate\Support\Facades\Http;

it('can lookup company name on the uk gazette service', function () {

    $name = 'Worksome';

    // Make the Virk API request.
    $response = Http::withBasicAuth(
        config('company-info.services.gazette.key'),
        ''
    )->get(config('company-info.services.gazette.base_url') . '/search/companies?q=' . $name);

    expect($response->ok())->toBe(true);

    ray([
        'body'      => $response->json(),
        'companies' => $response->json()['items'],
    ]);
});
