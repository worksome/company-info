<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

declare(strict_types=1);

use Worksome\CompanyInfo\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

expect()->extend('toHaveCompanyInfo', function (array $expected) {

    // Skip if a request failed.
    if ($this->value === null) {
        test()->markTestSkipped();
    }

    expect($this->value)->toHaveCount(count($expected));

    expect($this->value[0])->toHaveKey('name', $expected[0]['name']);

    expect($this->value[0])->toHaveKey('number', $expected[0]['number']);

    return $this;
});
