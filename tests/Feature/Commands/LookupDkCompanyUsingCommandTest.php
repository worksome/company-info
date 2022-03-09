<?php

declare(strict_types=1);

it('looks up company info for dk market using artisan command', function (string $name, array $expected) {
    // Skip test if not configured with actual credentials (in phpunit.xml).
    if (
        config('company-info.services.virk.user_id') == ''
        || config('company-info.services.virk.password') == ''
    ) {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            'name'   => $name,
            'market' => 'dk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address', 'ZipCode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('dk-companies');
