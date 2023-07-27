<?php

namespace TutoraUK\Braze;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use ImmobiliareLabs\BrazeSDK\ClientAdapter\Psr18Adapter;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TutoraUK\Braze\ClientAdapter\LaravelAdapter;

class BrazeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-braze-api')
            ->hasConfigFile('braze');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Braze::class, function () {
            $apiKey = config('braze.api_key');
            $restEndpoint = config('braze.rest_endpoint');

            $adapter = match (config('braze.client_adapter')) {
                'laravel' => new LaravelAdapter(),
                'guzzle' => new Psr18Adapter(
                    new Client(),
                    new HttpFactory(),
                    new HttpFactory(),
                    new HttpFactory(),
                ),
                default => throw new Exception("Unknown BRAZE_CLIENT_ADAPTER. Supported adapters are 'laravel' or 'guzzle'")
            };

            return new Braze(
                $adapter,
                $apiKey && is_string($apiKey) ? $apiKey : '',
                $restEndpoint && is_string($restEndpoint) ? $restEndpoint : ''
            );
        });
    }
}
