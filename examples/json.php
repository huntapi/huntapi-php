<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use HuntApi\Client;

$client = new Client(); // reads HUNTAPI_API_KEY
$response = $client->mediaMetadata(['query' => 'https://www.youtube.com/watch?v=Z5YP8kznWZs']);
echo json_encode($response->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), "\n";
