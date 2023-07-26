<?php

namespace TutoraUK\Braze\Tests;

use Illuminate\Support\Facades\Config;
use ImmobiliareLabs\BrazeSDK\ClientAdapter\Psr18Adapter;
use ImmobiliareLabs\BrazeSDK\Region;
use TutoraUK\Braze\Braze;
use TutoraUK\Braze\ClientAdapter\LaravelAdapter;

class BrazeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('braze.api_key', 'abc123');
        Config::set('braze.rest_endpoint', Region::EU02);
    }

    public function testContainerInstanceOfBraze(): void
    {
        $this->assertInstanceOf(Braze::class, app(Braze::class));
    }

    public function testFacadeReturnsInstanceOfBraze(): void
    {
        $this->assertInstanceOf(Braze::class, \TutoraUK\Braze\Facades\Braze::getFacadeRoot());
    }

    public function testHelperReturnsInstanceOfBraze(): void
    {
        $this->assertInstanceOf(Braze::class, braze());
    }

    public function testBrazeInstantiatedWithLaravelAdapter(): void
    {
        $client = \TutoraUK\Braze\Facades\Braze::getClient();

        $adapter = (new \ReflectionClass($client))
            ->getProperty('adapter')
            ->getValue($client);

        $this->assertInstanceOf(LaravelAdapter::class, $adapter);
    }

    public function testBrazeInstantiatedWithPSRAdapter(): void
    {
        Config::set('braze.client_adapter', 'guzzle');

        $client = \TutoraUK\Braze\Facades\Braze::getClient();

        $adapter = (new \ReflectionClass($client))
            ->getProperty('adapter')
            ->getValue($client);

        $this->assertInstanceOf(Psr18Adapter::class, $adapter);
    }
}
