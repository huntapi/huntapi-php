<?php

declare(strict_types=1);

namespace HuntApi\Exception;

use HuntApi\RawResponse;

/**
 * HuntAPI returned a non-success HTTP status.
 */
final class ApiException extends HuntApiException
{
    public readonly int $status;

    public function __construct(
        public readonly RawResponse $rawResponse,
        public readonly mixed $responseBody = null,
        public readonly ?string $errorMessage = null,
    ) {
        $this->status = $rawResponse->status;
        parent::__construct($errorMessage ?? sprintf('HuntAPI API request failed with status %d.', $rawResponse->status), $rawResponse->status);
    }
}
