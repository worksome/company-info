<?php

namespace Worksome\CompanyInfo\Commands;

use Illuminate\Console\Command;

final class CompanyInfoCommand extends Command
{
    public $signature = 'company-info:lookup
        {name   : The company name to lookup.}
        {market : The market to lookup.}';

    public $description = 'Lookup company and return information.';

    public function handle(): int
    {
        $this->comment('OK');

        return self::SUCCESS;
    }
}
