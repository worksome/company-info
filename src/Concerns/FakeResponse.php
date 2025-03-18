<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Concerns;

use Worksome\CompanyInfo\DataObjects\CompanyInfo;

trait FakeResponse
{
    /** @var array<CompanyInfo>|null $fakeResponse Faked response. */
    private array|null $fakeResponse = null;

    /**
     * Set faked response.
     *
     * @param array $response Faked response.
     */
    public function setFakeResponse(array $response): void
    {
        $this->fakeResponse = collect($response)->map(function ($company) {
            return new CompanyInfo(
                number: $company['number'],
                name: $company['name'],
                address1: $company['address1'],
                address2: $company['address2'],
                zipcode: $company['zipcode'],
                city: $company['city'],
                country: $company['country'],
                phone: $company['phone'],
                email: $company['email'],
            );
        })->toArray();
    }
}
