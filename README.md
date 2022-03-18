# Company Info

Lookup company information from public services.

[![Tests](https://github.com/worksome/company-info/actions/workflows/run-tests.yml/badge.svg)](https://github.com/worksome/company-info/actions/workflows/run-tests.yml)
[![PHPStan](https://github.com/worksome/company-info/actions/workflows/phpstan.yml/badge.svg)](https://github.com/worksome/company-info/actions/workflows/phpstan.yml)

If your app needs information about a given company, then there are public service API's that can provide that information. It can be a lot of work implementing support for each different service, especially if you need it for several different countries.

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

## Configuration

The following environment variables are available to configure the package:

```ini
# Define the default country, used when a country is not given.
COMPANY_INFO_DEFAULT_COUNTRY=dk

# Define URL and credentials for the Danish CVR API service.
COMPANY_INFO_CVRAPI_BASE_URL=https://cvrapi.dk/api

# Define URL and credentials for the Danish VIRK service.
COMPANY_INFO_VIRK_BASE_URL=http://distribution.virk.dk
COMPANY_INFO_VIRK_USER_ID=xxx
COMPANY_INFO_VIRK_PASSWORD=xxx

# Define URL and credentials for the English Gazette service.
COMPANY_INFO_GAZETTE_BASE_URL=https://api.companieshouse.gov.uk
COMPANY_INFO_GAZETTE_KEY=xxx

# Define maximum number of results returned (works for VIRK and Gazette).
COMPANY_INFO_MAX_RESULTS=10

# Define the default provider for each country.
COMPANY_INFO_PROVIDER_DK=virk # Can also be cvrapi.
COMPANY_INFO_PROVIDER_GB=gazette
COMPANY_INFO_PROVIDER_NO=cvrapi
```

To obtain access and credentials to the Danish VIRK service, contact Erhvervsstyrelsen via this page: https://datacvr.virk.dk/artikel/system-til-system-adgang-til-cvr-data.

To obtain access and credentials to the English Gazette service, contact XXX via this page: XXX.

## Usage

The package provides two general static methods, allowing you to perform company lookups from either name or number (in Denmark, the number is the CVR number).

The methods take a `country` parameter, which must be one of the supported countries, or left out or empty to use the configured default country.

The country code selects the appropriate underlying service for the lookup. Currently the package supports countries `dk` and `no` for the Danish CVR API service, `dk` for the Danish VIRK service and `gb` for the English Gazette service. If an invalid country is given, an `InvalidCountryException` is thrown.

Example lookups:

```php
use Worksome\CompanyInfo\Facades\CompanyInfo;

$companies = CompanyInfo::lookupName('worksome', 'dk');
// - or -
$companies = CompanyInfo::lookupNumber('37990485', 'dk');
```

The lookup methods returns an array of companies matching the name or number, or `null` if the underlying service failed.

The array may be empty, if there are no companies matching the given name or number.

If there are matches (or just one), then each matching company can be found in the array.

### Company info data structure

The company information is a simplified uniform representation of the data provided by the underlying service.

```php
[
    'number'   => '37990485',
    'name'     => 'Worksome ApS',
    'address1' => 'Toldbodgade 35, 1.',
    'address2' => '',
    'zipcode'  => '1253',
    'city'     => 'København K',
    'country'  => 'DK',
    'phone'    => '',
    'email'    => '',
]
```

The `number` field is the CVR number for the `dk` country and company number for the `gb` country.

## Artisan

The package adds a command for performing lookups at the commandline. This is probably most useful while configuring the services, to check if your access is working.

```sh
php artisan company-info:lookup --name=worksome --country=dk
php artisan company-info:lookup --number=37990485 --country=dk
```

The company information will be displayed in table format.

## Testing

The package has a suite of functional tests as well as phpstan analysis and coding style checking.

Run all the tests like this:

```sh
composer test
```

See `composer.json` for other options for tests and linting.

The test suite uses a faked http response instead of calling the actual external services. The faked response is a copy of an actual response from the service.

If you want to run tests against the actual external service, copy `phpunit.xml.dist` to `phpunit.xml` and change the `COMPANY_INFO_xxx` variables in it to the credentials you have obtained.

## Ideas for improvements

There is a [free Danish API service](https://cvrapi.dk/documentation) for CVR lookups, which does not require obtaining access from VIRK, but is rate-limited.

It might be useful to add a driver-based approach for the lookups, so that for example the currently supported direct VIRK access can be replaced with the CVRAPI service for small businesses.

Like:

```ini
COMPANY_INFO_VIRK_DRIVER=virk
# - or --
COMPANY_INFO_VIRK_DRIVER=cvrapi
```

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
