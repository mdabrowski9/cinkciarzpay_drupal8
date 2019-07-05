<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class PaymentNotCompletedException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PaymentNotCompletedException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'payment-not-completed';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
