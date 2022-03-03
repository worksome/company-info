<?php

namespace Worksome\CompanyInfo\Commands;

use Illuminate\Console\Command;

class CompanyInfoCommand extends Command
{
    public $signature = 'company-info';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
