<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class PointOfSaleNotActiveException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PointOfSaleNotActiveException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'point-of-sale-not-active';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
