<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpNotFoundException;

/**
 * Class StoreNotFoundException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class StoreNotFoundException extends HttpNotFoundException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'store-not-found';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
