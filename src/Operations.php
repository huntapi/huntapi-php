<?php

declare(strict_types=1);

namespace HuntApi;

// Generated from the HuntAPI OpenAPI document. Do not edit by hand.

/**
 * One method per documented HuntAPI endpoint. Used by {@see Client}.
 */
trait Operations
{
    /**
     * @param array<string, mixed> $params
     */
    abstract protected function callOperation(string $name, array $params, ?RequestOptions $options): JsonResponse|BinaryResponse;

    /**
     * Audio Download. Download audio from a URL via HuntAPI and receive a job id. Credit cost: 1 credit per call.
     *
     * `GET / POST /v1/audio/download`
     *
     * @param array{query: string, download_type?: string, max_duration?: int|float, audio_quality?: string, audio_format?: string, webhook_url?: string, webhook_authorization?: string, fields?: string, is_async?: bool, soft_fail?: bool} $params
     *   - query (required): URL to download audio from.
     *   - download_type: Desired download type. Supported values: audio (default).
     *   - max_duration: Maximum duration of the downloaded content in seconds. If the audio is longer than this value, only the content up to this duration will be downloaded.
     *   - audio_quality: Desired audio quality.
     *   - audio_format: Desired output format for the audio.
     *   - webhook_url: URL of the webhook where results will be sent. When specified, the system will attempt to send the response to this URL up to 3 times with a 5-second delay bet…
     *   - webhook_authorization: Authorization header for the webhook. This parameter allows you to add authentication to your webhook endpoint.
     *   - fields: Comma-separated list of fields to keep in the response, with dot notation for nested fields (e.g. name,location.city). Does not change the credit cost.
     *   - is_async: Process the request asynchronously: the response is a job_id to poll on /v1/jobs/{id} (see waitForJob).
     *   - soft_fail: Return HTTP 200 even when an error occurs; the error is then in the response body.
     */
    public function audioDownload(array $params, ?RequestOptions $options = null): JsonResponse
    {
        $response = $this->callOperation('audio_download', $params, $options);
        \assert($response instanceof JsonResponse);

        return $response;
    }

    /**
     * Jobs. Poll status, progress (0–100), and result of an async HuntAPI job.
     *
     * `GET /v1/jobs/{id}`
     *
     * @param array{id: string} $params
     *   - id (required): Job UUID returned as job_id by async endpoints such as /v1/video/download and /v1/audio/download.
     */
    public function jobs(array $params, ?RequestOptions $options = null): JsonResponse
    {
        $response = $this->callOperation('jobs', $params, $options);
        \assert($response instanceof JsonResponse);

        return $response;
    }

    /**
     * Media Metadata. Extract metadata from a media URL without downloading the file. Credit cost: 1 credit per call.
     *
     * `GET /v1/media/metadata`
     *
     * @param array{query: string, fields?: string, is_async?: bool, soft_fail?: bool} $params
     *   - query (required): Media URL to inspect (YouTube, Instagram, TikTok, Vimeo, X, Facebook, Twitch, Reddit, etc.).
     *   - fields: Comma-separated list of fields to keep in the response, with dot notation for nested fields (e.g. name,location.city). Does not change the credit cost.
     *   - is_async: Process the request asynchronously: the response is a job_id to poll on /v1/jobs/{id} (see waitForJob).
     *   - soft_fail: Return HTTP 200 even when an error occurs; the error is then in the response body.
     */
    public function mediaMetadata(array $params, ?RequestOptions $options = null): JsonResponse
    {
        $response = $this->callOperation('media_metadata', $params, $options);
        \assert($response instanceof JsonResponse);

        return $response;
    }

    /**
     * Stats. Infrastructure health for an engine or endpoint over the last hour. Not scoped to your account or tenant. Enabled per account: HTTP 403 means contact support to activate it.
     *
     * `GET /v1/stats`
     *
     * @param array{engine?: string, path?: string} $params
     *   - engine: API family to check, for example video. Provide at least engine or path.
     *   - path: Specific endpoint to check, for example /v1/video/download. If you also pass engine, use an endpoint from that API.
     */
    public function stats(array $params = [], ?RequestOptions $options = null): JsonResponse
    {
        $response = $this->callOperation('stats', $params, $options);
        \assert($response instanceof JsonResponse);

        return $response;
    }

    /**
     * Usage. Retrieve real-time usage statistics and credit balance for your Huntapi account.
     *
     * `GET /v1/usage`
     *
     * @param array{} $params
     */
    public function usage(array $params = [], ?RequestOptions $options = null): JsonResponse
    {
        $response = $this->callOperation('usage', $params, $options);
        \assert($response instanceof JsonResponse);

        return $response;
    }

    /**
     * Video Download. Credit cost: 1 credit per call.
     *
     * `GET / POST /v1/video/download`
     *
     * @param array{query: string, download_type?: string, max_duration?: int|float, video_quality?: string, video_format?: string, webhook_url?: string, webhook_authorization?: string, fields?: string, is_async?: bool, soft_fail?: bool} $params
     *   - query (required): Video URL to download.
     *   - download_type: Desired download type. You have three options:
     *   - max_duration: Maximum duration of the downloaded content in seconds. If the video/audio is longer than this value, only the content up to this duration will be downloaded.
     *   - video_quality: Desired video quality. Available options:
     *   - video_format: Desired output format for the video. Available options:
     *   - webhook_url: URL of the webhook where results will be sent. When specified, the system will attempt to send the response to this URL up to 3 times with a 5-second delay bet…
     *   - webhook_authorization: Authorization header for the webhook. This parameter allows you to add authentication to your webhook endpoint. This value will be included in the Authorizatio…
     *   - fields: Comma-separated list of fields to keep in the response, with dot notation for nested fields (e.g. name,location.city). Does not change the credit cost.
     *   - is_async: Process the request asynchronously: the response is a job_id to poll on /v1/jobs/{id} (see waitForJob).
     *   - soft_fail: Return HTTP 200 even when an error occurs; the error is then in the response body.
     */
    public function videoDownload(array $params, ?RequestOptions $options = null): JsonResponse
    {
        $response = $this->callOperation('video_download', $params, $options);
        \assert($response instanceof JsonResponse);

        return $response;
    }
}
