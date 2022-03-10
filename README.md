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

```php
use Worksome\CompanyInfo\CompanyInfo;

$companies = CompanyInfo::lookupName('worksome');
```

## Artisan

```sh
php artisan company-info:lookup --name=worksome --market=dk
```

## Testing

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Odinn Adalsteinsson](https://github.com/odinns)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
