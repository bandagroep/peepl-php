<?php

declare(strict_types=1);

namespace Peepl;

use RuntimeException;

class PeeplException extends RuntimeException
{
    private int $httpStatus;
    private mixed $responseBody;

    public function __construct(string $message, int $httpStatus = 0, mixed $responseBody = null)
    {
        parent::__construct($message);
        $this->httpStatus   = $httpStatus;
        $this->responseBody = $responseBody;
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getResponseBody(): mixed
    {
        return $this->responseBody;
    }
}
