<?php

declare(strict_types=1);

it('looks up company info on name for dk country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'   => $name,
            '--country' => 'dk',
        ])
        ->assertSuccessful()
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected[config('company-info.countries.dk.provider')]
        );
})
->with('dk-companies')
->skip(fn () => config('company-info.countries.dk.provider') === 'cvrapi' && config('company-info.providers.cvrapi.user_agent') === '')
->skip(fn () => config('company-info.countries.dk.provider') === 'virk' && (config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === ''));

it('looks up company info on name for dk country using artisan command, output as json', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--name'    => $name,
            '--country' => 'dk',
            '--json'    => null,
        ])
        ->assertSuccessful();
        // @TODO: ->expectsOutput('the json output')
})
->with('dk-companies')
->skip(fn () => config('company-info.countries.dk.provider') === 'cvrapi' && config('company-info.providers.cvrapi.user_agent') === '')
->skip(fn () => config('company-info.countries.dk.provider') === 'virk' && (config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === ''));

it('looks up company info on number for dk country using artisan command', function (string $name, string $number, array $expected) {
    $this
        ->artisan('company-info:lookup', [
            '--number'  => $number,
            '--country' => 'dk',
        ])
        ->assertSuccessful()
        ->expectsTable(
            ['Number', 'Name', 'Address1', 'Address2', 'Zipcode', 'City', 'Country', 'Phone', 'Email'],
            $expected[config('company-info.countries.dk.provider')]
        );
})
->with('dk-companies')
->skip(fn () => config('company-info.countries.dk.provider') === 'cvrapi' && config('company-info.providers.cvrapi.user_agent') === '')
->skip(fn () => config('company-info.countries.dk.provider') === 'virk' && (config('company-info.providers.virk.user_id') === '' || config('company-info.providers.virk.password') === ''));
