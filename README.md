# Company Info

Lookup company information from public services.

[![Tests](https://github.com/worksome/company-info/actions/workflows/run-tests.yml/badge.svg)](https://github.com/worksome/company-info/actions/workflows/run-tests.yml)
[![PHPStan](https://github.com/worksome/company-info/actions/workflows/phpstan.yml/badge.svg)](https://github.com/worksome/company-info/actions/workflows/phpstan.yml)

If your app needs information about a given company, then there are public service API's that can provide that information. It can be a lot of work implementing support for each different service, especially if you need it for several different countries or regions.

The Company Info package provides a service that wraps the public services and gives you a simple way to perform the lookups.

Currently the package supports the public service API's of the Danish VIRK and the UK Gazette services.

## Installation

You can install the package via composer:

```bash
composer require worksome/company-info
```

You can publish the config file with:

```sh
php artisan vendor:publish --tag="company-info-config"
```

## Usage

The package provides two general static methods, allowing you to perform company lookups from either name or number (in Denmark, the number is the CVR number). The methods take a `market` parameter, which must be one of the supported market. The market code selects the appropriate underlying service for the lookup.

```php
use Worksome\CompanyInfo\CompanyInfo;

$companies = CompanyInfo::lookupName('worksome', 'dk');
// - or -
$companies = CompanyInfo::lookupNumber('37990485', 'dk');
```

The lookup methods returns an array of companies matching the name or number, or `null` if the underlying service failed.

The array may be empty, if there are no companies matching the given name or number.

If there are matches (or just one), then each matching company can be found in the array.

### Company info data structure

The company information is a simplified representation of the data provided by the underlying service.

```php
[
    'number'   => '37990485',
    'name'     => 'Worksome ApS',
    'address'  => 'Toldbodgade 35, 1.',
    'address2' => '',
    'zipcode'  => '1253',
    'city'     => 'København K',
    'country'  => 'DK',
]
```

## Artisan

The package adds a command for performing lookups at the commandline. This is probably most useful while configuring the services, to check if your access is working.

```sh
php artisan company-info:lookup --name=worksome --market=dk
php artisan company-info:lookup --number=37990485 --market=dk
```

## Testing

The package has a suite of functional tests as well as phpstan analysis and coding style checking.

Run all the tests like this:

```sh
composer test
```

See `composer.json` for other options for tests and linting.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Odinn Adalsteinsson](https://github.com/odinns)
- [Worksome](https://github.com/worksome)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
