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
            if (! ($apiKey = config('braze.api_key')) || ! is_string($apiKey)) {
                throw new Exception('Ensure the BRAZE_API_KEY configuration value is correctly defined in your .env file.');
            }

            if (! ($restEndpoint = config('braze.rest_endpoint')) || ! is_string($restEndpoint)) {
                throw new Exception('Ensure BRAZE_REST_ENDPOINT configuration value is correctly defined in your .env file.');
            }

            $adapter = match (config('braze.client_adapter')) {
                'laravel' => new LaravelAdapter(),
                'guzzle' => new Psr18Adapter(
                    new Client(),
                    new HttpFactory(),
                    new HttpFactory(),
                    new HttpFactory(),
                ),
                default => throw new Exception("Unknown BRAZE_CLIENT_ADAPTER. Supported adapters are either 'laravel' or 'guzzle'")
            };

            return new Braze($adapter, $apiKey, $restEndpoint);
        });
    }
}
