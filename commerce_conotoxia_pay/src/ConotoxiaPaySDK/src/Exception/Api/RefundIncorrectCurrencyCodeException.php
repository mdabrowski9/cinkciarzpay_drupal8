<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class RefundIncorrectCurrencyCodeException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class RefundIncorrectCurrencyCodeException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'refund-incorrect-currency-code';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
