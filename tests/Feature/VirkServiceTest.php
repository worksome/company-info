<?php

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\CompanyInfoVirk;

it('can lookup a company name on dk virk with faked service', function (string $name, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response),
    ]);

    $companies = CompanyInfoVirk::lookup($name);

    companyLookupExpectations($companies, $expected);
})->with('dk-companies');

it('can lookup a company name on dk virk with actual service', function (string $name, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    $companies = CompanyInfoVirk::lookup($name);

    companyLookupExpectations($companies, $expected);
})->with('dk-companies');
