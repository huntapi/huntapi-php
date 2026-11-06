<?php

declare(strict_types=1);

namespace HuntApi;

// Generated from the HuntAPI OpenAPI document. Do not edit by hand.

/**
 * Path, methods, response kind and parameter names of every documented operation.
 */
final class Endpoints
{
    /**
     * @var array<string, array{path: string, methods: list<'GET'|'POST'>, response: 'json'|'any', required: list<string>, params: list<string>}>
     */
    public const ALL = [
        'audio_download' => [
            'path' => '/v1/audio/download',
            'methods' => ['GET', 'POST'],
            'response' => 'json',
            'required' => ['query'],
            'params' => ['query', 'download_type', 'max_duration', 'audio_quality', 'audio_format', 'webhook_url', 'webhook_authorization', 'fields', 'is_async', 'soft_fail'],
        ],
        'jobs' => [
            'path' => '/v1/jobs/{id}',
            'methods' => ['GET'],
            'response' => 'json',
            'required' => ['id'],
            'params' => ['id'],
        ],
        'media_metadata' => [
            'path' => '/v1/media/metadata',
            'methods' => ['GET'],
            'response' => 'json',
            'required' => ['query'],
            'params' => ['query', 'fields', 'is_async', 'soft_fail'],
        ],
        'stats' => [
            'path' => '/v1/stats',
            'methods' => ['GET'],
            'response' => 'json',
            'required' => [],
            'params' => ['engine', 'path'],
        ],
        'usage' => [
            'path' => '/v1/usage',
            'methods' => ['GET'],
            'response' => 'json',
            'required' => [],
            'params' => [],
        ],
        'video_download' => [
            'path' => '/v1/video/download',
            'methods' => ['GET', 'POST'],
            'response' => 'json',
            'required' => ['query'],
            'params' => ['query', 'download_type', 'max_duration', 'video_quality', 'video_format', 'webhook_url', 'webhook_authorization', 'fields', 'is_async', 'soft_fail'],
        ],
    ];

    /**
     * SDK method name to endpoint name, for batch().
     *
     * @var array<string, string>
     */
    public const METHODS = [
        'audioDownload' => 'audio_download',
        'jobs' => 'jobs',
        'mediaMetadata' => 'media_metadata',
        'stats' => 'stats',
        'usage' => 'usage',
        'videoDownload' => 'video_download',
    ];
}
