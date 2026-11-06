<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use HuntApi\Client;

$client = new Client(); // reads HUNTAPI_API_KEY
$submitted = $client->videoDownload(['query' => 'https://www.youtube.com/watch?v=Z5YP8kznWZs', 'video_quality' => '720p']);
$jobId = \is_array($submitted->data) ? (string) ($submitted->data['job_id'] ?? '') : '';
$job = $client->waitForJob($jobId, onProgress: static function (mixed $job): void {
    if (\is_array($job)) {
        echo $job['status'] ?? '?', ' ', $job['progress'] ?? 0, "%\n";
    }
});
print_r($job->data);
