<?php

namespace Worksome\CompanyInfo\Commands;

use Illuminate\Console\Command;
use Worksome\CompanyInfo\CompanyInfo;

final class CompanyInfoLookupCommand extends Command
{
    public $signature = 'company-info:lookup
        {name   : The company name to lookup.}
        {market : The market to lookup.}';

    public $description = 'Lookup company and return information.';

    public function handle(CompanyInfo $companyInfo): int
    {
        $companies = collect($companyInfo->lookup($this->argument('name'), $this->argument('market')))
            ->map(function ($item) {
                return [
                    $item['number'],
                    $item['name'],
                    $item['address'],
                    $item['zipCode'],
                    $item['city'],
                    $item['country'],
                ];
            });

        $this->table(
            ['Number', 'Name', 'Address', 'ZipCode', 'City', 'Country'],
            $companies->toArray()
        );

        return self::SUCCESS;
    }
}
