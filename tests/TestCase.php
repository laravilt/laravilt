<?php

namespace Laravilt\Laravilt\Tests;

use Laravilt\Laravilt\LaraviltServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Additional setup if needed
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaraviltServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Setup environment for testing
        config()->set('database.default', 'testing');
    }
}
