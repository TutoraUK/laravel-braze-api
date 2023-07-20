<?php

namespace TutoraUK\Braze\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TutoraUK\Braze\BrazeServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BrazeServiceProvider::class,
        ];
    }
}
