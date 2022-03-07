<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Support;

use Illuminate\Support\Manager;

final class CompanyInfoManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return strval($this->config->get('company-info.default') ?? 'null');
    }
    // @TODO
}
