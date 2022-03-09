<?php

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\CompanyInfo;
use Worksome\CompanyInfo\Exceptions\InvalidMarketException;

it('can lookup a company name using faked dk service', function (string $name, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfo::lookup($name, 'dk'), $expected);
})->with('dk-companies');

it('can lookup a company name using actual dk service', function (string $name, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfo::lookup($name, 'dk'), $expected);
})->with('dk-companies');

it('can lookup a company name using faked uk service', function (string $name, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfo::lookup($name, 'uk'), $expected);
})->with('uk-companies');

it('can lookup a company name on the uk gazette with actual service', function (string $name, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfo::lookup($name, 'uk'), $expected);
})->with('uk-companies');

it('throws exception when trying to lookup a company name on an invalid market', function () {
    CompanyInfo::lookup('hest', 'invalid');
})->throws(InvalidMarketException::class);
