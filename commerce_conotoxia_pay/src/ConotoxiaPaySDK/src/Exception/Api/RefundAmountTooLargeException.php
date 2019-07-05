<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class RefundAmountTooLargeException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class RefundAmountTooLargeException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'refund-amount-too-large';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
