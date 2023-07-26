<?php

return [
    'api_key' => env('BRAZE_API_KEY'),
    'rest_endpoint' => env('BRAZE_REST_ENDPOINT'),
    'client_adapter' => env('BRAZE_CLIENT_ADAPTER', 'laravel'),
];
