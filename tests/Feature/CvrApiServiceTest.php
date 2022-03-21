<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\Support\CompanyInfoManager;

it('can lookup a company name on dk cvr api with faked service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['cvrapi']),
    ]);

    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupName($name, 'dk'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('dk-companies');

it('can lookup a company name on dk cvr api with actual service', function (string $name, string $number, array $expected) {
    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupName($name, 'dk'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('dk-companies');

it('can lookup a company number on dk cvr api with faked service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['cvrapi']),
    ]);

    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('dk-companies');

it('can lookup a company number on dk cvr api with actual service', function (string $name, string $number, array $expected) {
    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('dk-companies');

it('can lookup a company name on no cvr api with faked service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['cvrapi']),
    ]);

    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupName($name, 'no'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('no-companies');

it('can lookup a company name on no cvr api with actual service', function (string $name, string $number, array $expected) {
    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupName($name, 'no'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('no-companies');

it('can lookup a company number on no cvr api with faked service', function (string $name, string $number, array $expected, array $response) {
    Http::fake([
        '*' => Http::response($response['cvrapi']),
    ]);

    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupNumber($number, 'no'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('no-companies');

it('can lookup a company number on no cvr api with actual service', function (string $name, string $number, array $expected) {
    $service = $this->app->get(CompanyInfoManager::class)->driver('cvrapi');

    expect($service->lookupNumber($number, 'no'))->toHaveCompanyInfo($expected['cvrapi']);
})
->with('no-companies');
