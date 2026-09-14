<?php

it('rejects an unknown frontend stack before touching the application', function () {
    $this->artisan('laravilt:install', ['--stack' => 'svelte'])
        ->expectsOutputToContain('Invalid stack [svelte]')
        ->assertFailed();
});
