<?php

namespace TutoraUK\Braze\ClientAdapter;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use ImmobiliareLabs\BrazeSDK\ClientAdapter\ClientAdapterInterface;
use ImmobiliareLabs\BrazeSDK\ClientResolvedResponse;

class LaravelAdapter implements ClientAdapterInterface
{
    private array $headers = [];

    private string $baseURI = '';

    public function setBaseURI(string $baseURI): void
    {
        $this->baseURI = $baseURI;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function makeRequest(string $method, string $path, string $body = null): Response
    {
        return Http::send($method, $path, [
            'base_uri' => $this->baseURI,
            'headers' => $this->headers,
            'body' => $body,
        ]);
    }

    /**
     * @param  Response  $httpResponse
     */
    public function resolveResponse(mixed $httpResponse): ClientResolvedResponse
    {
        return new ClientResolvedResponse($httpResponse->status(), $httpResponse->body());
    }
}
