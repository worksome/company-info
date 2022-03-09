<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Exceptions;

use InvalidArgumentException;

final class InvalidMarketException extends InvalidArgumentException
{
    public function __construct(string $invalidMarket)
    {
        parent::__construct("[{$invalidMarket}] is not a valid market.");
    }
}
