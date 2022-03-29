<?php

declare(strict_types=1);

dataset('dk-companies', [
    [
        'worksome',
        '37990485',
        [
            'virk' => [
                [
                    'number'   => '37990485',
                    'name'     => 'Worksome ApS',
                    'address1' => 'Toldbodgade 35, 1.',
                    'address2' => '',
                    'zipcode'  => '1253',
                    'city'     => 'København K',
                    'country'  => 'DK',
                    'phone'    => '71991931',
                    'email'    => 'accounting@worksome.com',
                ],
            ],
            'cvrapi' => [
                [
                    'number'   => '37990485',
                    'name'     => 'Worksome ApS',
                    'address1' => 'Toldbodgade 35, 1',
                    'address2' => '',
                    'zipcode'  => '1253',
                    'city'     => 'København K',
                    'country'  => 'DK',
                    'phone'    => '71991931',
                    'email'    => 'accounting@worksome.com',
                ],
            ],
        ],
        [
            'virk' => [
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
                                    'telefonNummer' => [
                                        [
                                            'sidstOpdateret' => '2017-12-07T14:14:51.000+01:00',
                                            'hemmelig' => false,
                                            'kontaktoplysning' => '71991931',
                                            'periode' => [
                                                'gyldigFra' => '2017-11-03',
                                                'gyldigTil' => null,
                                            ],
                                        ],
                                    ],
                                    'cvrNummer' => 37990485,
                                    'elektroniskPost' => [
                                        [
                                            'sidstOpdateret' => '2019-12-12T12:43:55.000+01:00',
                                            'hemmelig' => false,
                                            'kontaktoplysning' => 'accounting@worksome.com',
                                            'periode' => [
                                                'gyldigFra' => '2019-12-12',
                                                'gyldigTil' => null,
                                            ],
                                        ],
                                    ],
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
            'cvrapi' => [
                'vat' => 37990485,
                'name' => 'Worksome ApS',
                'address' => 'Toldbodgade 35, 1',
                'zipcode' => 1253,
                'city' => 'København K',
                'cityname' => null,
                'protected' => true,
                'phone' => 71991931,
                'email' => 'accounting@worksome.com',
                'fax' => null,
                'startdate' => '06/09 - 2016',
                'enddate' => null,
                'employees' => 51,
                'addressco' => null,
                'industrycode' => 620100,
                'industrydesc' => 'Computerprogrammering',
                'companycode' => 80,
                'companydesc' => 'Anpartsselskab',
                'creditstartdate' => null,
                'creditbankrupt' => false,
                'creditstatus' => null,
                'owners' => null,
                'productionunits' => [
                    [
                        'pno' => 1021729643,
                        'main' => true,
                        'name' => 'Worksome ApS',
                        'address' => 'Toldbodgade 35, 1',
                        'zipcode' => 1253,
                        'city' => 'København K',
                        'cityname' => null,
                        'protected' => true,
                        'phone' => null,
                        'email' => null,
                        'fax' => null,
                        'startdate' => '06/09 - 2016',
                        'enddate' => null,
                        'employees' => 51,
                        'addressco' => null,
                        'industrycode' => 620100,
                        'industrydesc' => 'Computerprogrammering',
                    ]
                ],
                't' => 100,
                'version' => 6
            ],
        ],
    ],
]);
