<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class PointOfSaleForbiddenErrorUrlException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PointOfSaleForbiddenErrorUrlException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'point-of-sale-forbidden-error-url';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
