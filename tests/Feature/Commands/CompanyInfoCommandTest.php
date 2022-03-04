<?php

declare(strict_types=1);

it('looks up company info for dk market', function () {
    $this
        ->artisan('company-info:lookup', [
            'name'   => 'worksome',
            'market' => 'dk',
        ])
        ->assertSuccessful();
});
