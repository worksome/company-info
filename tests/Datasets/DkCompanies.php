<?php

declare(strict_types=1);

dataset('dk-companies', [
    [
        'worksome',
        '37990485',
        [
            [
                '37990485',
                'Worksome ApS',
                'Toldbodgade 35, 1.',
                '',
                '1253',
                'København K',
                'DK',
            ],
        ],
        [
            'took' => 6,
            'timed_out' => false,
            '_shards' => [
                'total' => 6,
                'successful' => 6,
                'skipped' => 0,
                'failed' => 0,
            ],
            'hits' => [
                'total' => 1,
                'max_score' => 1.0,
                'hits' => [
                    [
                        '_index' => 'cvr-v-20200115',
                        '_type' => '_doc',
                        '_id' => '4006642697',
                        '_score' => 1.0,
                        '_source' => [
                            'Vrvirksomhed' => [
                                'cvrNummer' => 37990485,
                                'virksomhedMetadata' => [
                                    'nyesteNavn' => [
                                        'navn' => 'Worksome ApS',
                                    ],
                                    'nyesteBeliggenhedsadresse' => [
                                        'vejkode' => 7540,
                                        'fritekst' => null,
                                        'adresseId' => '0a3f50a1-357f-32b8-e044-0003ba298018',
                                        'vejnavn' => 'Toldbodgade',
                                        'bogstavTil' => null,
                                        'conavn' => null,
                                        'bogstavFra' => null,
                                        'periode' => [
                                            'gyldigFra' => '2021-08-04',
                                            'gyldigTil' => null,
                                        ],
                                        'kommune' => [
                                            'sidstOpdateret' => '2006-11-13T00:00:00.000+01:00',
                                            'kommuneNavn' => 'KØBENHAVN',
                                            'kommuneKode' => 101,
                                            'periode' => [
                                                'gyldigFra' => '2007-01-01',
                                                'gyldigTil' => null,
                                            ],
                                        ],
                                        'husnummerFra' => 35,
                                        'postboks' => null,
                                        'sidstOpdateret' => '2021-08-04T16:53:37.000+02:00',
                                        'postnummer' => 1253,
                                        'etage' => '1',
                                        'bynavn' => null,
                                        'husnummerTil' => null,
                                        'sidedoer' => null,
                                        'landekode' => 'DK',
                                        'sidstValideret' => '2021-08-04T16:54:27.983+02:00',
                                        'postdistrikt' => 'København K',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
]);
