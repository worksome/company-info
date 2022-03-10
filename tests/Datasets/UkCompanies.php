<?php

declare(strict_types=1);

dataset('uk-companies', [
    [
        'worksome',
        '11615731',
        [
            [
                '11615731',
                'WORKSOME LTD',
                '3 Waterhouse Square',
                '138 - 142 Holborn',
                'EC1N 2SW',
                'London',
                'GB',
            ],
        ],
        [
            'items_per_page' => 20,
            'page_number' => 1,
            'kind' => 'search#companies',
            'total_results' => 1,
            'start_index' => 0,
            'items' => [
                [
                    'title' => 'WORKSOME LTD',
                    'company_status' => 'active',
                    'snippet' => '',
                    'description_identifier' => [
                        'incorporated-on',
                    ],
                    'date_of_creation' => '2018-10-10',
                    'links' => [
                        'self' => '/company/11615731',
                    ],
                    'company_number' => '11615731',
                    'address_snippet' => '3 Waterhouse Square, 138 - 142 Holborn, London, United Kingdom, EC1N 2SW',
                    'kind' => 'searchresults#company',
                    'matches' => [
                        'title' => [
                            1,
                            8,
                        ],
                        'snippet' => [],
                    ],
                    'address' => [
                        'address_line_2' => '138 - 142 Holborn',
                        'premises' => '3',
                        'locality' => 'London',
                        'address_line_1' => 'Waterhouse Square',
                        'country' => 'United Kingdom',
                        'postal_code' => 'EC1N 2SW',
                    ],
                    'company_type' => 'ltd',
                    'description' => '11615731 - Incorporated on 10 October 2018',
                ],
            ],
        ],
    ],
]);
