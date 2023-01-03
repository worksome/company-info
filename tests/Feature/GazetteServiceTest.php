<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\Facades\CompanyInfo;
use Worksome\CompanyInfo\Support\CompanyInfoManager;

it(
    'can lookup a company name on the gb gazette with faked service',
    function (string $name, string $number, array $expected, array $response) {
        Http::fake(['*' => Http::response($response['gazette'])]);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('gazette');
    
        expect($service->lookupName($name, 'gb'))->toHaveCompanyInfo(
            $expected[config('company-info.countries.gb.provider')]
        );
    }
)
->with('gb-companies');

it(
    'can lookup a company name on the gb gazette with faked response',
    function (string $name, string $number, array $expected, array $response) {
        CompanyInfo::fake(['name' => $name, 'country' => 'gb'], $expected['gazette']);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('gazette');
    
        expect($service->lookupName($name, 'gb'))->toHaveCompanyInfo(
            $expected[config('company-info.countries.gb.provider')]
        );
    }
)
->with('gb-companies');

it(
    'can lookup a company name on the gb gazette with actual service',
    function (string $name, string $number, array $expected) {
        $service = $this->app->get(CompanyInfoManager::class)->driver('gazette');
    
        expect($service->lookupName($name, 'gb'))->toHaveCompanyInfo(
            $expected[config('company-info.countries.gb.provider')]
        );
    }
)
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');

it(
    'can lookup a company number on the gb gazette with faked service',
    function (string $name, string $number, array $expected, array $response) {
        Http::fake(['*' => Http::response($response['gazette'])]);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('gazette');
    
        expect($service->lookupNumber($number, 'gb'))->toHaveCompanyInfo(
            $expected[config('company-info.countries.gb.provider')]
        );
    }
)
->with('gb-companies');

it(
    'can lookup a company number on the gb gazette with faked response',
    function (string $name, string $number, array $expected, array $response) {
        CompanyInfo::fake(['number' => $number, 'country' => 'gb'], $expected['gazette']);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('gazette');
    
        expect($service->lookupNumber($number, 'gb'))->toHaveCompanyInfo(
            $expected[config('company-info.countries.gb.provider')]
        );
    }
)
->with('gb-companies');

it(
    'can lookup a company number on the gb gazette with actual service',
    function (string $name, string $number, array $expected) {
        $service = $this->app->get(CompanyInfoManager::class)->driver('gazette');
    
        expect($service->lookupNumber($number, 'gb'))->toHaveCompanyInfo(
            $expected[config('company-info.countries.gb.provider')]
        );
    }
)
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');
