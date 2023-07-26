<?php

namespace TutoraUK\Braze\Tests\ClientAdapter;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use ImmobiliareLabs\BrazeSDK\Region;
use TutoraUK\Braze\ClientAdapter\LaravelAdapter;
use TutoraUK\Braze\Tests\TestCase;

class LaravelAdapterTest extends TestCase
{
    private LaravelAdapter $adapter;

    public function setUp(): void
    {
        parent::setUp();

        $this->adapter = new LaravelAdapter();
    }

    public function testMakeRequest(): void
    {
        Http::shouldReceive('send')->once()
            ->with('GET', '/path', ['base_uri' => '', 'headers' => [], 'body' => null])
            ->andReturn($this->mock(Response::class));

        $this->adapter->makeRequest('GET', '/path');
    }

    public function testSetBaseUri(): void
    {
        $this->adapter->setBaseURI(Region::EU02);

        Http::shouldReceive('send')->once()
            ->with('GET', '/path', ['base_uri' => Region::EU02, 'body' => null, 'headers' => []])
            ->andReturn($this->mock(Response::class));

        $this->adapter->makeRequest('GET', '/path');
    }

    public function testSetHeaders(): void
    {
        $this->adapter->setHeaders(['Content-Type' => 'application/json']);

        Http::shouldReceive('send')->once()
            ->with('GET', '/path', ['base_uri' => '', 'body' => null, 'headers' => ['Content-Type' => 'application/json']])
            ->andReturn($this->mock(Response::class));

        $this->adapter->makeRequest('GET', '/path');
    }

    public function testResolveResponse(): void
    {
        Http::fake();

        $resolvedResponse = $this->adapter->resolveResponse(
            $this->adapter->makeRequest('GET', '/path')
        );

        $this->assertSame(200, $resolvedResponse->getStatusCode());
    }

    public function testResolveExceptionResponse(): void
    {
        Http::fake(fn () => Http::response(status: 500));

        $resolvedResponse = $this->adapter->resolveResponse(
            $this->adapter->makeRequest('GET', '/path')
        );

        $this->assertSame(500, $resolvedResponse->getStatusCode());
    }
}
