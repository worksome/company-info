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

    public function toArray(): array
    {
        return [
            'number'   => $this->number,
            'name'     => $this->name,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'zipcode'  => $this->zipcode,
            'city'     => $this->city,
            'country'  => $this->country,
            'phone'    => $this->phone,
            'email'    => $this->email,
        ];
    }
}
