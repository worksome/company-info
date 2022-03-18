<?php

declare(strict_types=1);

it('looks up company info on name for dk country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'   => $name,
            '--country' => 'dk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected
        )
        ->assertSuccessful();
})
->with('dk-companies')
->skip(fn () => config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === '');

it('looks up company info on name for dk country using artisan command, output as json', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'    => $name,
            '--country' => 'dk',
            '--json'    => null,
        ])
        // @TODO: ->expectsOutput('the json output')
        ->assertSuccessful();
})
->with('dk-companies')
->skip(fn () => config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === '');

it('looks up company info on number for dk country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--number'  => $number,
            '--country' => 'dk',
        ])
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected
        )
        ->assertSuccessful();
})
->with('dk-companies')
->skip(fn () => config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === '');
