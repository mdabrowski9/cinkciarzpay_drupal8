<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class PaymentMoneyBelowLimitException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PaymentMoneyBelowLimitException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'payment-money-below-limit';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
