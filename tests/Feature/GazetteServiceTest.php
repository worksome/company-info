<?php

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\CompanyInfoGazette;

it('can lookup a company name on the uk gazette with faked service', function (string $name, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    $companies = CompanyInfoGazette::lookup($name);

    companyLookupExpectations($companies, $expected);
})->with('uk-companies');

it('can lookup a company name on the uk gazette with actual service', function (string $name, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    $companies = CompanyInfoGazette::lookup($name);

    companyLookupExpectations($companies, $expected);
})->with('uk-companies');
