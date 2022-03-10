<?php

declare(strict_types=1);

it('looks up company info on name for uk market using artisan command', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            '--name'   => $name,
            '--market' => 'uk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('uk-companies');

it('looks up company info on number for uk market using artisan command', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            '--number' => $number,
            '--market' => 'uk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('uk-companies');
