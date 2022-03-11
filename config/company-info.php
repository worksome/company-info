<?php

declare(strict_types=1);

return [
    'services' => [

        /*
        |--------------------------------------------------------------------------
        | Default market.
        |--------------------------------------------------------------------------
        |
        */

        'default_market' => env('COMPANY_INFO_DEFAULT_MARKET', 'dk'),

        /*
        |--------------------------------------------------------------------------
        | Virk - Public company data from DK.
        |--------------------------------------------------------------------------
        |
        */

        'virk' => [
            'base_url' => env('COMPANY_INFO_VIRK_BASE_URL', 'http://distribution.virk.dk'),
            'user_id'  => env('COMPANY_INFO_VIRK_USER_ID', env('VIRK_USER_ID')),
            'password' => env('COMPANY_INFO_VIRK_PASSWORD', env('VIRK_PASSWORD')),
        ],

        /*
        |--------------------------------------------------------------------------
        | The Gazette - Public company data from UK.
        |--------------------------------------------------------------------------
        |
        */

        'gazette' => [
            'base_url' => env('COMPANY_INFO_GAZETTE_BASE_URL', 'https://api.companieshouse.gov.uk'),
            'key'      => env('COMPANY_INFO_GAZETTE_KEY', env('GAZETTE_KEY')),
        ],
    ],
];
