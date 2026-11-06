# HuntAPI PHP SDK

The official PHP SDK for the [HuntAPI](https://www.huntapi.com) media download API.

Download video and audio from public media URLs, or extract their metadata, with one async REST API.

The SDK exposes **6 methods**, one per documented endpoint (with array-shape PHPDoc for static analysis), plus a generic `request()`. It sends requests through any PSR-18 client and uses Guzzle by default.

## Requirements

- PHP 8.1 or newer

## Installation

```sh
composer require huntapi/sdk
```

## Get your API key

[Sign up for HuntAPI](https://app.huntapi.com/register) or sign in, then copy your API key from the [dashboard](https://app.huntapi.com). The client reads the `HUNTAPI_API_KEY` environment variable when no key is passed.

## Quick start

```php
<?php

require 'vendor/autoload.php';

use HuntApi\Client;

$client = new Client(getenv('HUNTAPI_API_KEY') ?: null);
$response = $client->mediaMetadata(['query' => 'https://www.youtube.com/watch?v=Z5YP8kznWZs']);
print_r($response->data);
```

Parameter arrays use the names of the [API reference](https://docs.huntapi.com). Unknown names throw a `SerializationException`; use `request()` for undocumented parameters.

## Async jobs

Download endpoints are asynchronous: they return a `job_id`, and jobs can run for up to 12 hours. `waitForJob()` polls `GET /v1/jobs/{id}` until a terminal status (`CompletedJob`, `Error`, `NotFound`, `BadRequest`):

```php
$submitted = $client->videoDownload(['query' => 'https://www.youtube.com/watch?v=Z5YP8kznWZs', 'video_quality' => '720p']);
$job = $client->waitForJob($submitted->data['job_id'], onProgress: static function (array $job): void {
    echo $job['status'], ' ', $job['progress'] ?? 0, "%\n";
});
print_r($job->data);
```

## GET or POST

Methods use GET when the endpoint supports it (query string). POST sends the same parameters as JSON:

```php
use HuntApi\RequestOptions;

$client->audioDownload(['query' => 'test'], new RequestOptions(method: 'POST'));
```

`null` values are omitted, `false` and `0` are sent, and lists repeat the parameter name.

## Any endpoint

```php
$response = $client->request('GET', '/v1/usage');
```

## Errors

```php
use HuntApi\Exception\ApiException;

try {
    $client->mediaMetadata(['query' => 'https://www.youtube.com/watch?v=Z5YP8kznWZs']);
} catch (ApiException $exception) {
    echo $exception->status, ': ', $exception->getMessage();
}
```

| Exception | When |
| --- | --- |
| `ConfigurationException` | Missing API key, invalid options or unsupported method. |
| `SerializationException` | A required parameter is missing, unknown or can't be sent. |
| `TransportException` | Network failure or timeout. |
| `ApiException` | Non-2xx status (`status`, `errorMessage`, `responseBody`, `rawResponse`). |
| `ResponseDecodingException` | A success response could not be decoded. |

All of them extend `HuntApi\Exception\HuntApiException`.

## Retries

Requests are retried up to 3 times after a network error, a `408`, `500`, `502`, `503` or `504`, or a rate limit — which the API returns as `401` (or `429`) with a `Rate limit exceeded` message. Per-key quota errors (`…: quota daily`) are not retried, nor are `400`, `402`, `404` or client-side timeouts. The delay starts at 1 second and grows 1.5× per retry (capped at 30 seconds); a `Retry-After` header wins.

```php
$client = new Client(null, ['max_retries' => 5, 'retry_delay' => 0.5]);
$client->mediaMetadata(['query' => 'https://www.youtube.com/watch?v=Z5YP8kznWZs'], new RequestOptions(maxRetries: 0)); // one request without retries
```

## Batch requests

`batch()` sends several calls with at most 10 requests in flight (`$concurrency`), through Guzzle's connection pool, and returns one `BatchResult` per call in input order. A failing call never stops the others. With a custom PSR-18 client the calls run one after another.

```php
$inputs = ['https://www.youtube.com/watch?v=Z5YP8kznWZs', 'https://www.youtube.com/watch?v=jNQXAC9IVRw'];
$calls = array_map(static fn(string $value): array => ['mediaMetadata', ['query' => $value]], $inputs);

foreach ($client->batch($calls, concurrency: 5) as $result) {
    if ($result->ok()) {
        print_r($result->value->data);
    } else {
        echo $inputs[$result->index], ': ', $result->error->getMessage(), "\n";
    }
}
```

| Constant | Default | Description |
| --- | --- | --- |
| `Client::DEFAULT_CONCURRENCY` | `10` | Tasks run at the same time by batch |
| `Client::DEFAULT_TIMEOUT` | `120.0` | Request timeout (seconds) |
| `Client::MAX_RETRIES` | `3` | Retry attempts after a network error, a 408/5xx or a rate limit |
| `Client::RETRY_BACKOFF_FACTOR` | `1.5` | Exponential backoff multiplier |
| `Client::DEFAULT_RETRY_DELAY` | `1.0` | Delay before the first retry (seconds) |

## Options and custom HTTP clients

```php
$client = new Client(null, [
    'timeout' => 60.0,               // seconds, default 120 (default Guzzle client only)
    'headers' => ['X-Trace' => 'abc'],
    'http_client' => $psr18Client,   // optional: any PSR-18 client
]);
```

## Endpoints

6 methods, generated from the [OpenAPI document](https://app.huntapi.com/openapi).

| Method | HTTP | Description |
| --- | --- | --- |
| `audioDownload()` | GET / POST `/v1/audio/download` | Download audio from a URL via HuntAPI and receive a job id. |
| `jobs()` | GET `/v1/jobs/{id}` | Poll status, progress (0–100), and result of an async HuntAPI job. |
| `mediaMetadata()` | GET `/v1/media/metadata` | Extract metadata from a media URL without downloading the file. |
| `stats()` | GET `/v1/stats` | Infrastructure health for an engine or endpoint over the last hour. Not scoped to your account or tenant. Enabled per account: HTTP 403 mea… |
| `usage()` | GET `/v1/usage` | Retrieve real-time usage statistics and credit balance for your Huntapi account. |
| `videoDownload()` | GET / POST `/v1/video/download` | Video Download |

## All HuntAPI SDKs

| SDK | Package | Install |
| --- | --- | --- |
| Node.js | [`@huntapi/sdk`](https://www.npmjs.com/package/@huntapi/sdk) | `npm install @huntapi/sdk` |
| Python | [`huntapi`](https://pypi.org/project/huntapi/) | `pip install huntapi` |
| Go | [`huntapi-go`](https://pkg.go.dev/github.com/huntapi/huntapi-go) | `go get github.com/huntapi/huntapi-go` |
| .NET | [`HuntApi`](https://www.nuget.org/packages/HuntApi) | `dotnet add package HuntApi` |
| Ruby | [`huntapi`](https://rubygems.org/gems/huntapi) | `gem install huntapi` |
| PHP | [`huntapi/sdk`](https://packagist.org/packages/huntapi/sdk) | `composer require huntapi/sdk` |
| Java | [`huntapi-java`](https://github.com/huntapi/huntapi-java) | build from source, see its README |
| CLI | [`@huntapi/cli`](https://www.npmjs.com/package/@huntapi/cli) | `npm install -g @huntapi/cli` |
| MCP server | [`@huntapi/mcp`](https://www.npmjs.com/package/@huntapi/mcp) | `npx -y @huntapi/mcp` |

## License

MIT — see [LICENSE](LICENSE).
