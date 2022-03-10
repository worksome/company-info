<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Commands;

use Illuminate\Console\Command;
use Worksome\CompanyInfo\CompanyInfo;

final class CompanyInfoLookupCommand extends Command
{
    public $signature = 'company-info:lookup
        {--name=   : The company name to lookup.}
        {--number= : The company number to lookup.}
        {--market= : The market to lookup.}';

    public $description = 'Lookup company and return information.';

    /**
     * Handle the lookup command.
     *
     * @return int
     */
    public function handle(): int
    {
        if ($this->option('name')) {
            // @phpstan-ignore-next-line
            $this->lookupName($this->option('name'), $this->option('market'));
        }

        if ($this->option('number')) {
            // @phpstan-ignore-next-line
            $this->lookupNumber($this->option('number'), $this->option('market'));
        }

        return self::SUCCESS;
    }

    /**
     * Lookup company from name.
     *
     * @param string $name   Name of company.
     * @param string $market Market code.
     *
     * @return void
     */
    private function lookupName(string $name, string $market): void
    {
        $this->displayCompanies(CompanyInfo::lookupName($name, $market));
    }

    /**
     * Lookup company from number.
     *
     * @param string $number Number of company.
     * @param string $market Market code.
     *
     * @return void
     */
    private function lookupNumber(string $number, string $market): void
    {
        $this->displayCompanies(CompanyInfo::lookupNumber($number, $market));
    }

    private function displayCompanies(?array $companies): void
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
