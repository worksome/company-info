<?php

declare(strict_types=1);

namespace Worksome\CompanyInfo\Concerns;

trait FakeResponse
{
    /** @var $fakeResponse Faked response. */
    private ?array $fakeResponse = null;

    /**
     * Set faked response.
     *
     * @param array $response Faked response.
     *
     * @return void
     */
    public function setFakeResponse(array $response): void
    {
        $this->fakeResponse = $response;
    }
}
