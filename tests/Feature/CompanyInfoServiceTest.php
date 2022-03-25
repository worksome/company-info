<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\Facades\CompanyInfo;
use Worksome\CompanyInfo\Exceptions\InvalidCountryException;

it('can lookup a company name using faked dk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response[config('company-info.countries.dk.provider')])
    ]);

    expect(CompanyInfo::lookupName($name, 'dk'))->toHaveCompanyInfo($expected[config('company-info.countries.dk.provider')]);
})
->with('dk-companies');

it('can lookup a company name using actual dk service', function (string $name, string $number, array $expected) {
    expect(CompanyInfo::lookupName($name, 'dk'))->toHaveCompanyInfo($expected[config('company-info.countries.dk.provider')]);
})
->with('dk-companies')
->skip(fn () => config('company-info.countries.dk.provider') === 'virk' && (config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === ''));

it('can lookup a company number using faked dk service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response[config('company-info.countries.dk.provider')])
    ]);

    expect(CompanyInfo::lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected[config('company-info.countries.dk.provider')]);
})
->with('dk-companies');

it('can lookup a company number using actual dk service', function (string $name, string $number, array $expected) {
    expect(CompanyInfo::lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected[config('company-info.countries.dk.provider')]);
})
->with('dk-companies')
->skip(fn () => config('company-info.countries.dk.provider') === 'virk' && (config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === ''));

it('can lookup a company name using faked gb service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response[config('company-info.countries.gb.provider')])
    ]);

    expect(CompanyInfo::lookupName($name, 'gb'))->toHaveCompanyInfo($expected[config('company-info.countries.gb.provider')]);
})
->with('gb-companies');

it('can lookup a company name using actual gb service', function (string $name, string $number, array $expected) {
    expect(CompanyInfo::lookupName($name, 'gb'))->toHaveCompanyInfo($expected[config('company-info.countries.gb.provider')]);
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');

it('throws exception when trying to lookup a company name on an invalid country', function () {
    CompanyInfo::lookupName('hest', 'invalid');
})
->throws(InvalidCountryException::class);
