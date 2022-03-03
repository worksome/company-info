<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Exceptions;

use InvalidArgumentException;

final class InvalidCountryException extends InvalidArgumentException
{
    public function __construct(string $invalidCountry)
    {
        parent::__construct("[{$invalidCountry}] is not a valid country.");
    }
}
