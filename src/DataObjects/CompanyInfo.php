<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\DataObjects;

class CompanyInfo
{
    public function __construct(
        public ?string $number,
        public ?string $name,
        public ?string $address1,
        public ?string $address2,
        public ?string $zipcode,
        public ?string $city,
        public ?string $country,
        public ?string $phone = null,
        public ?string $email = null,
    ) {
    }
}
