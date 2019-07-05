<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class TransactionLimitExceedException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class TransactionLimitExceedException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'transaction-limit-exceed';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
