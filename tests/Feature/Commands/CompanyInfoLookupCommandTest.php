<?php

declare(strict_types=1);

it('looks up company info for dk market using artisan command', function (string $lookupName, array $expected) {
    if (config('company-info.services.virk.user_id') == '') {
        test()->markTestSkipped();
    }

    if (config('company-info.services.virk.password') == '') {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            'name'   => $lookupName,
            'market' => 'dk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address', 'ZipCode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('dk-companies');

it('looks up company info for uk market using artisan command', function (string $lookupName, array $expected) {
    if (config('company-info.services.gazette.key') == '') {
        test()->markTestSkipped();
    }

    $this
        ->artisan('company-info:lookup', [
            'name'   => $lookupName,
            'market' => 'uk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address', 'ZipCode', 'City', 'Country'],
            $expected
        )
        ->assertSuccessful();
})->with('uk-companies');
