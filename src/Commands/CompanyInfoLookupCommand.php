<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Commands;

use Illuminate\Console\Command;
use Worksome\CompanyInfo\CompanyInfo;

final class CompanyInfoLookupCommand extends Command
{
    /**
     * Options for JSON display.
     */
    private const JSON_OPTIONS = JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_NUMERIC_CHECK|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR;

    public $signature = 'company-info:lookup
        {--name=   : The company name to lookup.}
        {--number= : The company number to lookup.}
        {--country= : The country to lookup.}
        {--json    : Output as JSON, instead of table.}
        ';

    public $description = 'Lookup company and return information.';

    /**
     * Handle the lookup command.
     */
    public function handle(CompanyInfo $service): int
    {
        $country = $this->option('country') ?? config('company-info.default-country');

        $companies = [];

        if ($this->option('name')) {
            $companies = $service->lookupName($this->option('name'), $country);
        }

        if ($this->option('number')) {
            $companies = $service->lookupNumber($this->option('number'), $country);
        }

        $this->option('json') ? $this->displayJson($companies) : $this->displayTable($companies);

        return self::SUCCESS;
    }

    /**
     * Display company information in human-readable table format.
     *
     * @param array|null $companies Array of companies.
     */
    private function displayJson(array|null $companies): void
    {
        $json = json_encode($companies, self::JSON_OPTIONS);

        if ($json !== false) {
            $this->line($json);
        }
    }

    /**
     * Display company information in human-readable table format.
     *
     * @param array|null $companies Array of companies.
     */
    private function displayTable(array|null $companies): void
    {
        $companies = collect($companies)->map(function ($company) {
            return [
                $company->number,
                $company->name,
                $company->address1,
                $company->address2,
                $company->zipcode,
                $company->city,
                $company->country,
                $company->phone,
                $company->email,
            ];
        });

        $this->table(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $companies->toArray()
        );
    }
}
