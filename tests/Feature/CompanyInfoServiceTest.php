<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\CompanyInfo;
use Worksome\CompanyInfo\Exceptions\InvalidMarketException;

it('can lookup a company name using faked dk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfo::lookupName($name, 'dk'), $expected);
})->with('dk-companies');

it('can lookup a company name using actual dk service', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfo::lookupName($name, 'dk'), $expected);
})->with('dk-companies');

it('can lookup a company number using faked dk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfo::lookupNumber($number, 'dk'), $expected);
})->with('dk-companies');

it('can lookup a company number using actual dk service', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfo::lookupNumber($number, 'dk'), $expected);
})->with('dk-companies');

it('can lookup a company name using faked uk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response)
    ]);

    companyLookupExpectations(CompanyInfo::lookupName($name, 'uk'), $expected);
})->with('uk-companies');

it('can lookup a company name on the uk gazette with actual service', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    companyLookupExpectations(CompanyInfo::lookupName($name, 'uk'), $expected);
})->with('uk-companies');

it('throws exception when trying to lookup a company name on an invalid market', function () {
    CompanyInfo::lookupName('hest', 'invalid');
})->throws(InvalidMarketException::class);
