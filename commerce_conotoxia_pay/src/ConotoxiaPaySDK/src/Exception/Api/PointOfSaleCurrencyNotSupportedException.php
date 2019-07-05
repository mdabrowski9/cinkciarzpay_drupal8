<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class PointOfSaleCurrencyNotSupportedException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PointOfSaleCurrencyNotSupportedException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'point-of-sale-currency-not-supported';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
