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
    private const JSON_OPTIONS = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR;

    public $signature = 'company-info:lookup
        {--name=   : The company name to lookup.}
        {--number= : The company number to lookup.}
        {--market= : The market to lookup.}
        {--json    : Output as JSON, instead of table.}
        ';

    public $description = 'Lookup company and return information.';

    /**
     * Handle the lookup command.
     *
     * @return int
     */
    public function handle(): int
    {
        $market = $this->option('market') ?? config('company-info.default-market');

        $companies = [];

        if ($this->option('name')) {
            // @phpstan-ignore-next-line
            $companies = CompanyInfo::lookupName($this->option('name'), $market);
        }

        if ($this->option('number')) {
            // @phpstan-ignore-next-line
            $companies = CompanyInfo::lookupNumber($this->option('number'), $market);
        }

        if ($this->option('json')) {
            $this->displayJson($companies);
        } else {
            $this->displayTable($companies);
        }

        return self::SUCCESS;
    }

    /**
     * Display company information in human-readable table format.
     *
     * @param  array|null $companies Array of companies.
     *
     * @return void
     */
    private function displayJson(?array $companies): void
    {
        $json = json_encode($companies, self::JSON_OPTIONS);

        if ($json !== false) {
            $this->line($json);
        }
    }

    /**
     * Display company information in human-readable table format.
     *
     * @param  array|null $companies Array of companies.
     *
     * @return void
     */
    private function displayTable(?array $companies): void
    {
        $companies = collect($companies)->map(function ($item) {
            return [
                $item['number'],
                $item['name'],
                $item['address1'],
                $item['address2'],
                $item['zipcode'],
                $item['city'],
                $item['country'],
            ];
        });

        $this->table(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country'],
            $companies->toArray()
        );
    }
}
