<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Worksome\CompanyInfo\Facades\CompanyInfo;
use Worksome\CompanyInfo\Support\CompanyInfoManager;

it(
    'can lookup a company name on dk virk with faked service',
    function (string $name, string $number, array $expected, array $response) {
        Http::fake(['*' => Http::response($response['virk'])]);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('virk');
    
        expect($service->lookupName($name, 'dk'))->toHaveCompanyInfo($expected['virk']);
    }
)
->with('dk-companies');

it(
    'can lookup a company name on dk virk with faked response',
    function (string $name, string $number, array $expected, array $response) {
        CompanyInfo::fake(['name' => $name, 'country' => 'dk'], $expected['virk']);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('virk');
    
        expect($service->lookupName($name, 'dk'))->toHaveCompanyInfo($expected['virk']);
    }
)
->with('dk-companies');

it(
    'can lookup a company name on dk virk with actual service',
    function (string $name, string $number, array $expected) {
        $service = $this->app->get(CompanyInfoManager::class)->driver('virk');
    
        expect($service->lookupName($name, 'dk'))->toHaveCompanyInfo($expected['virk']);
    }
)
->with('dk-companies')
->skip(
    fn () => config('company-info.providers.virk.user_id') === '' || config(
        'company-info.providers.virk.password'
    ) === ''
);

it(
    'can lookup a company number on dk virk with faked service',
    function (string $name, string $number, array $expected, array $response) {
        Http::fake(['*' => Http::response($response['virk'])]);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('virk');
    
        expect($service->lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected['virk']);
    }
)
->with('dk-companies');

it(
    'can lookup a company number on dk virk with faked response',
    function (string $name, string $number, array $expected, array $response) {
        CompanyInfo::fake(['number' => $number, 'country' => 'dk'], $expected['virk']);
    
        $service = $this->app->get(CompanyInfoManager::class)->driver('virk');
    
        expect($service->lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected['virk']);
    }
)
->with('dk-companies');

it(
    'can lookup a company number on dk virk with actual service',
    function (string $name, string $number, array $expected) {
        $service = $this->app->get(CompanyInfoManager::class)->driver('virk');
    
        expect($service->lookupNumber($number, 'dk'))->toHaveCompanyInfo($expected['virk']);
    }
)
->with('dk-companies')
->skip(
    fn () => config('company-info.providers.virk.user_id') === '' || config(
        'company-info.providers.virk.password'
    ) === ''
);
