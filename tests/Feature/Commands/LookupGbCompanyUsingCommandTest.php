<?php

declare(strict_types=1);

it('looks up company info on name for gb country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'    => $name,
            '--country' => 'gb',
        ])
        ->assertSuccessful()
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected[config('company-info.countries.gb.provider')]
        );
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');

it('looks up company info on name for gb country using artisan command, output as json', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'    => $name,
            '--country' => 'gb',
            '--json'    => null,
        ])
        ->assertSuccessful()
        ->expectsOutput(trim(file_get_contents('tests/Files/worksome-gb.json')));
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');

it('looks up company info on number for gb country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--number'  => $number,
            '--country' => 'gb',
        ])
        ->assertSuccessful()
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected[config('company-info.countries.gb.provider')]
        );
})
->with('gb-companies')
->skip(fn () => config('company-info.providers.gazette.key') === '');
