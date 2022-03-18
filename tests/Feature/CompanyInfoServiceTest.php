<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\Facades\CompanyInfo;
use Worksome\CompanyInfo\Exceptions\InvalidCountryException;

it('can lookup a company name using faked dk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['virk'])
    ]);

    expect(CompanyInfo::lookupName($name, 'dk'))->toHaveCompanyInfo($expected);
})
->with('dk-companies');

it('can lookup a company name using actual dk virk service', function (string $name, string $number, array $expected) {
    expect(CompanyInfo::lookupName($name, 'dk'))->toHaveCompanyInfo($expected);
})
->with('dk-companies')
->skip(fn () => config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === '');

it('can lookup a company number using faked dk virk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['virk'])
    ]);

    expect(CompanyInfo::lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected);
})
->with('dk-companies');

it('can lookup a company number using actual dk virk service', function (string $name, string $number, array $expected) {
    expect(CompanyInfo::lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected);
})
->with('dk-companies')
->skip(fn () => config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === '');

it('can lookup a company name using faked gb gazette service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['gazette'])
    ]);

    expect(CompanyInfo::lookupName($name, 'gb'))->toHaveCompanyInfo($expected);
})
->with('gb-companies');

it('can lookup a company name using actual gb gazette service', function (string $name, string $number, array $expected) {
    expect(CompanyInfo::lookupName($name, 'gb'))->toHaveCompanyInfo($expected);
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');

it('throws exception when trying to lookup a company name on an invalid country', function () {
    CompanyInfo::lookupName('hest', 'invalid');
})
->throws(InvalidCountryException::class);
