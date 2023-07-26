<?php

namespace TutoraUK\Braze\Tests;

use Illuminate\Support\Facades\Config;
use ImmobiliareLabs\BrazeSDK\Region;
use TutoraUK\Braze\Braze;

class BrazeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('braze.api_key', 'abc123');
        Config::set('braze.rest_endpoint', Region::EU02);
    }

    public function testFacadeReturnsInstanceOfBraze(): void
    {
        $this->assertInstanceOf(Braze::class, \TutoraUK\Braze\Facades\Braze::getFacadeRoot());
    }

    public function testHelperReturnsInstanceOfBraze(): void
    {
        $this->assertInstanceOf(Braze::class, braze());
    }
}
