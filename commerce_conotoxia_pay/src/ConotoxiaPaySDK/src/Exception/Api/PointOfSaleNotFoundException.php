<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpNotFoundException;

/**
 * Class PointOfSaleNotFoundException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PointOfSaleNotFoundException extends HttpNotFoundException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'point-of-sale-not-found';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
