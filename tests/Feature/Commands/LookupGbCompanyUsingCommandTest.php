<?php

declare(strict_types=1);

it('looks up company info on name for gb country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'    => $name,
            '--country' => 'gb',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected
        )
        ->assertSuccessful();
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');

it('looks up company info on number for gb country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--number'  => $number,
            '--country' => 'gb',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected
        )
        ->assertSuccessful();
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');
