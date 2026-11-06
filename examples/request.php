<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use HuntApi\Client;

$client = new Client(); // reads HUNTAPI_API_KEY
try {
    $response = $client->request('GET', '/v1/usage');
    if ($response instanceof HuntApi\JsonResponse) {
        print_r($response->data);
    }
} catch (HuntApi\Exception\ApiException $exception) {
    fwrite(STDERR, sprintf("HTTP %d: %s\n", $exception->status, $exception->getMessage()));
}
