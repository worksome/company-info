<?php

declare(strict_types=1);

it('looks up company info for uk market using artisan command', function (string $name, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            'name'   => $name,
            'market' => 'uk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address', 'ZipCode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('uk-companies');
