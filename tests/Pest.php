<?php // phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols

declare(strict_types=1);

use Worksome\CompanyInfo\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function companyLookupExpectations(array $companies, array $expected): void
{
    expect($companies)->toHaveCount(count($expected));

    expect($companies)->toHaveKey('0.name', $expected[0][1]);

    expect($companies)->toHaveKey('0.number', $expected[0][0]);
}
