<?php

declare(strict_types=1);

it('looks up company info on name for dk market using artisan command', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            '--name'   => $name,
            '--market' => 'dk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('dk-companies');

it('looks up company info on number for dk market using artisan command', function (string $name, string $number, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            '--number' => $number,
            '--market' => 'dk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('dk-companies');
