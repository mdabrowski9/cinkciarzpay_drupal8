<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class PointOfSaleDeletedException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class PointOfSaleDeletedException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'point-of-sale-deleted';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
