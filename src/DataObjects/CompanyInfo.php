<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\DataObjects;

class CompanyInfo
{
    public function __construct(
        public string|null $number,
        public string|null $name,
        public string|null $address1,
        public string|null $address2,
        public string|null $zipcode,
        public string|null $city,
        public string|null $country,
        public string|null $phone = null,
        public string|null $email = null,
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
