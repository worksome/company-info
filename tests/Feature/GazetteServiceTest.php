<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\CompanyInfoGazette;

it('can lookup a company name on the uk gazette with faked service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfoGazette::lookupName($name), $expected);
})->with('uk-companies');

it('can lookup a company name on the uk gazette with actual service', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfoGazette::lookupName($name), $expected);
})->with('uk-companies');

it('can lookup a company number on the uk gazette with faked service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfoGazette::lookupNumber($number), $expected);
})->with('uk-companies');

it('can lookup a company number on the uk gazette with actual service', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfoGazette::lookupNumber($number), $expected);
})->with('uk-companies');
