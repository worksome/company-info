<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Supported countries.
    |--------------------------------------------------------------------------
    |
    */

    'countries' => [
        'dk' => [
            'provider' => env('COMPANY_INFO_PROVIDER_DK', 'virk'),
        ],
        'gb' => [
            'provider' => env('COMPANY_INFO_PROVIDER_GB', 'gazette'),
        ],
        'no' => [
            'provider' => env('COMPANY_INFO_PROVIDER_NO', 'cvrapi'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default country.
    |--------------------------------------------------------------------------
    |
    */

    'default_country' => env('COMPANY_INFO_DEFAULT_COUNTRY', 'dk'),

    /*
    |--------------------------------------------------------------------------
    | Company information service providers.
    |--------------------------------------------------------------------------
    |
    */

    'providers' => [
        'cvrapi' => [
            'base_url'   => env('COMPANY_INFO_CVRAPI_BASE_URL', 'https://cvrapi.dk/api'),
            'user_agent' => env('COMPANY_INFO_CVRAPI_USER_AGENT', ''),
        ],
        'gazette' => [
            'base_url' => env('COMPANY_INFO_GAZETTE_BASE_URL', 'https://api.companieshouse.gov.uk'),
            'key'      => env('COMPANY_INFO_GAZETTE_KEY', env('GAZETTE_KEY')),
        ],
        'virk' => [
            'base_url' => env('COMPANY_INFO_VIRK_BASE_URL', 'http://distribution.virk.dk'),
            'user_id'  => env('COMPANY_INFO_VIRK_USER_ID', env('VIRK_USER_ID')),
            'password' => env('COMPANY_INFO_VIRK_PASSWORD', env('VIRK_PASSWORD')),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum number of results returned.
    |--------------------------------------------------------------------------
    |
    */

    'max_results' => env('COMPANY_INFO_MAX_RESULTS', 10),
];
