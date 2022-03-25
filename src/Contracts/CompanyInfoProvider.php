<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Contracts;

interface CompanyInfoProvider
{
    public function lookupName(string $name, string $country): ?array;

    public function lookupNumber(string $number, string $country): ?array;
}
